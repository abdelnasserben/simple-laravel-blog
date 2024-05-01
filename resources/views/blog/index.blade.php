@extends('base')

@section('title', 'Accueil du blog')

@section('content')

    <h1>Mon Blog</h1>
    <hr>

    @foreach($posts as $post)

        <h2>{{ $post->title }}</h2>

        @if ($post->image)
            <img src="{{ $post->getImageUrl() }}" alt="Photo de l'article" style="height: 150px">            
        @endif

        <p class="small">
            Catégorie: <strong>{{ $post->category?->name}}</strong>

            @if (!$post->tags->isEmpty())
                , Tags: 
                @foreach ($post->tags as $tag)
                    <span class="badge badge-sm bg-secondary">{{ $tag->name }}</span>
                @endforeach
            @endif
        </p>
        <p>{{ $post->content }}</p>
        <p>
            <a href="{{ route('blog.show', ['slug' => $post->slug, 'post' => $post->id]) }}" class="btn btn-sm btn-primary">Lire la suite</a>
        </p>

    @endforeach

    {{ $posts->links() }}

@endsection