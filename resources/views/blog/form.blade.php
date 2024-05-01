@php
    $tagsId = $post->tags()->pluck('id');
@endphp

<form action="" method="post" enctype="multipart/form-data">
    @csrf
    @method($post->id ? 'PATCH' : 'POST')
    <div class="form-row mb-4">
        <div class="row">
            <div class="col-2">
                <label for="image">Image</label>
                <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image">
                @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}">
                @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-row mb-4">
        <label for="slug">Slug</label>
        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $post->slug) }}">
        @error('slug')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-row mb-4">
        <label for="content">Contenu</label>
        <textarea name="content" id="content" cols="30" rows="10" class="form-control @error('content') is-invalid @enderror">{{ old('content', $post->content) }}</textarea>
        @error('content')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-row mb-4">
        <label for="category">Catégorie</label>
        <select name="category_id" id="category" class="form-select @error('category_id') is-invalid @enderror">
            <option value="">Choisissez une catégorie</option>
            @foreach ($categories as $category)
                <option @selected(old('category_id', $post->category_id) == $category->id) value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        @error('category_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-row mb-4">
        <label for="tags">Choisissez des Tags</label>
        <select name="tags[]" id="tags" class="form-select @error('tags') is-invalid @enderror" multiple>
            @foreach ($tags as $tag)
                <option @selected($tagsId->contains($tag->id)) value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>

        @error('tags')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">{{ $post->id ? 'Modifier' : 'Enregistrer'}}</button>
</form>