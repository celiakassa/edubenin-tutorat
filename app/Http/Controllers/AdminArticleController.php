<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class AdminArticleController extends Controller
{
    public function index(): Factory|View
    {
        $articles = Article::orderByDesc('created_at')->get();

        return view('admin.articles.index', ['articles' => $articles]);
    }

    public function create(): Factory|View
    {
        return view('admin.articles.form', ['article' => new Article()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateArticle($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['author_id'] = $request->user()->id;

        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('articles/images', 'public');
        }

        if ($request->hasFile('video')) {
            $data['video_path'] = $request->file('video')->store('articles/videos', 'public');
        }

        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;

        Article::create($data);

        return redirect()->route('admin.articles')->with('success', 'Article créé avec succès.');
    }

    public function edit(int $id): Factory|View
    {
        $article = Article::findOrFail($id);

        return view('admin.articles.form', ['article' => $article]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $article = Article::findOrFail($id);
        $data = $this->validateArticle($request);

        if ($data['title'] !== $article->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $article->id);
        }

        if ($request->hasFile('cover')) {
            if ($article->cover_path) {
                Storage::disk('public')->delete($article->cover_path);
            }
            $data['cover_path'] = $request->file('cover')->store('articles/images', 'public');
        }

        if ($request->hasFile('video')) {
            if ($article->video_path) {
                Storage::disk('public')->delete($article->video_path);
            }
            $data['video_path'] = $request->file('video')->store('articles/videos', 'public');
        }

        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($article->published_at ?? now()) : null;

        $article->update($data);

        return redirect()->route('admin.articles')->with('success', 'Article mis à jour.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $article = Article::findOrFail($id);
        if ($article->cover_path) {
            Storage::disk('public')->delete($article->cover_path);
        }
        if ($article->video_path) {
            Storage::disk('public')->delete($article->video_path);
        }
        $article->delete();

        return back()->with('success', 'Article supprimé.');
    }

    private function validateArticle(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'cover' => ['nullable', 'image', 'max:5120'],
            'video' => ['nullable', 'mimes:mp4,webm,mov', 'max:5120'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 2;

        while (Article::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
