<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormPostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BlogController extends Controller
{

    public function update(Post $post, FormPostRequest $request)
    {
        $post->update($this->uploadPostImageAndGetData($post, $request));
        $post->tags()->sync($request->validated('tags'));

        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', 'Artcile bien modifié');
    }

    public function edit(Post $post): View
    {
        return view('blog.edit', [
            'post' => $post,
            'categories' => Category::select(['id', 'name'])->get(),
            'tags' => Tag::select(['id', 'name'])->get()
        ]);
    }

    public function store(FormPostRequest $request)
    {

        $post = Post::create($this->uploadPostImageAndGetData(new Post(), $request));
        $post->tags()->sync($request->validated('tags'));

        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', 'Artcile bien créé');
    }

    public function create(): View
    {
        $post = new Post();
        $post->title = 'Mon article';
        $post->slug = 'mon-article';
        $post->content = 'Contenu de l\'article';

        return view('blog.create', [
            'post' => $post,
            'categories' => Category::select(['id', 'name'])->get(),
            'tags' => Tag::select(['id', 'name'])->get()
        ]);
    }

    public function index(): View
    {

        return view('blog.index', [
            'posts' =>  Post::with(['category', 'tags'])->orderBy('created_at', 'desc')->paginate(10)
        ]);
    }

    public function show(string $slug, Post $post): RedirectResponse|View
    {
        if ($post->slug !== $slug) {
            return to_route('blog.show', ['slug' => $post->slug, 'post' => $post->id]);
        }

        return view('blog.show', [
            'post' => $post
        ]);
    }

    private function uploadPostImageAndGetData(Post $post, FormPostRequest $request): array
    {
        $data = $request->validated();
        $image = array_key_exists('image', $data) ? $data['image'] : null;

        if($image == null || $image->getError()) {
            return $data;            
        }

        //TODO: delete old image if exists
        if($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        //TODO: store the image
        //$imagePath = $request->file('image')->storePublicly('blog', 'public'); other alternative
        $imagePath = $request->file('image')->store('blog', 'public');
        $data['image'] = $imagePath;
        return $data;
    }
}
