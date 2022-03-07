<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPostAdminNotification;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(6);

        $data = [
            'posts' => $posts
        ];
        
        return view('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        $data = [
            'categories' => $categories,
            'tags' => $tags
        ];

        return view('admin.posts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form_data = $request->all();

        $request->validate($this->getValidationRules());

        $new_post = new Post();
        // Versione senza fill
        // $new_post->title = $form_data['title'];
        // $new_post->category_id = $form_data['category_id'];
        // $new_post->content = $form_data['content'];
        $new_post->fill($form_data);
        
        $new_post->slug = Post::getUniqueSlugFromTitle($form_data['title']);

        // Gestione immagine del post
        if(isset($form_data['image'])) {
            // 1- Mettere l'immagine caricata nella cartella di Storage
            $img_path = Storage::put('post_covers', $form_data['image']);
            // 2- Salvare il path al file nella colonna cover del post
            $new_post->cover = $img_path;
        }

        $new_post->save();

        // Save tags relations
        if(isset($form_data['tags'])) {
            $new_post->tags()->sync($form_data['tags']);
        }

        // Mando un email all'amministatore dell'azienda per notificargli che un nuovo post è stato 
        // creato nel blog
        Mail::to('editor@boolpress.it')->send(new NewPostAdminNotification($new_post));

        return redirect()->route('admin.posts.show', ['post' => $new_post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        $data = [
            'post' => $post
        ];
        
        return view('admin.posts.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();

        $data = [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags
        ];

        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $form_data = $request->all();
        $request->validate($this->getValidationRules());

        $post = Post::findOrFail($id);
        
        // Aggiorno lo slug soltanto se l'utente in fase di modifica cambia il titolo
        if($form_data['title'] != $post->title) {
            $form_data['slug'] = Post::getUniqueSlugFromTitle($form_data['title']);
        }

        if($form_data['image']) {
            // Cancello il file vecchio
            if($post->cover) {
                Storage::delete($post->cover);
            }

            // Faccio l'upload il nuovo file
            $img_path = Storage::put('post_covers', $form_data['image']);

            // Salvo nella colonna cover il path al nuovo file
            $form_data['cover'] = $img_path;
        }
        
        $post->update($form_data);

        if(isset($form_data['tags'])) {
            $post->tags()->sync($form_data['tags']);
        } else {
            // Se non esiste la chiave tags in form_data
            // significa che l'utente a rimosso il check da tutti i tag
            // quindi se questo post aveva dei tag collegati li rimuovo
            $post->tags()->sync([]);
        }
        

        return redirect()->route('admin.posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->tags()->sync([]);
        if($post->cover) {
            Storage::delete($post->cover);
        }
        $post->delete();

        return redirect()->route('admin.posts.index');
    }

    protected function getValidationRules() {
        return [
            'title' => 'required|max:255',
            'content' => 'required|max:60000',
            'category_id' => 'exists:categories,id|nullable',
            'tags' => 'exists:tags,id',
            'image' => 'image|max:512'
        ];
    }
}
