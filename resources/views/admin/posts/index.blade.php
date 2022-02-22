@extends('layouts.dashboard')

@section('content')
        <section>
            <div class="container">
                <h1>lista dei post</h1>

                <div class="row row-cols-3">
                    @foreach ($posts as $post)
                        {{-- single post --}}
                        <div class="col">
                            <div class="card mt-2">
                                {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
                                <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text">{{ Str::substr($post->content, 0, 70) }}...</p>
                                <a href="{{ route('admin.posts.show', ['post' => $post->id]) }}" class="btn btn-primary">Leggi il post</a>
                                </div>
                            </div>
                        </div>
                        {{-- end single post --}}
                    @endforeach
                </div>
            </div>
        </section>
@endsection