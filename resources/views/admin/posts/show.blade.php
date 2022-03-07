@extends('layouts.dashboard')

@section('content')
    <section>
        <h1>{{ $post->title }}</h1>

        <div class="mb-2"><strong>Slug:</strong> {{ $post->slug }}</div>

        <div class="mb-2"><strong>Categoria:</strong> {{ $post->category ? $post->category->name : 'nessuna' }}</div>

        <div class="mb-2"><strong>Tags:</strong>
            @forelse ($post->tags as $tag)
                {{ $tag->name }}{{ $loop->last ? '' : ', ' }}
            @empty
                nessuno
            @endforelse
        </div>

        {{-- @if($post->tags->isNotEmpty())
            <div class="mb-2"><strong>Tags:</strong>
                @foreach ($post->tags as $tag)
                    {{ $tag->name }}{{ $loop->last ? '' : ', ' }}
                @endforeach
            </div>
        @endif --}}

        @if ($post->cover)
            <div>
                <img src="{{ asset('storage/' . $post->cover) }}" alt="{{ $post->title }}">
            </div>
        @endif

        <p>{{ $post->content }}</p>

        <div>
            <a href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">Modifica post</a>
        </div>

        <div>
            <form action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="post">
                @csrf
                @method('DELETE')

                <button class="btn btn-danger">Cancella</button>
            </form>
        </div>
    </section>
@endsection
