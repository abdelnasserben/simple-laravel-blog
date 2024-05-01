@extends('base')

@section('title', 'Accueil du blog')

@section('content')

    <h1>{{ $post->title }}</h1>
    @if ($post->image)
        <img src="{{ $post->getImageUrl() }}" alt="Photo de l'article" style="height: 150px">            
    @endif
    <p>{{ $post->content }}</p>

    <a href="{{ route('blog.edit', ['post' => $post]) }}" class="btn btn-sm btn-primary">Editer</a>

@endsection