<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        return Inertia::render('Posts/Index', [
            'posts' => Post::with('user:id,name')->latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        // Validamos los datos
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $request->user()->posts()->create($validated);

        return redirect()->route('posts.index');
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        if ($request->user()->cannot('update', $post)) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post->update($validated);

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index');
    }
}
