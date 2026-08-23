<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

final class BlogController extends Controller
{
    public function index(): Factory|View
    {
        $articles = Article::published()
            ->with('author')
            ->orderByDesc('published_at')
            ->take(9)
            ->get();

        return view('blog.index', [
            'featured' => $articles->first(),
            'recentArticles' => $articles->slice(1),
        ]);
    }

    public function show(Article $article): Factory|View
    {
        if (! $article->is_published || $article->published_at?->isFuture()) {
            abort(404);
        }

        $metaDescription = $article->excerpt ?? Str::limit(strip_tags($article->content), 155);

        return view('blog.show', ['article' => $article, 'metaDescription' => $metaDescription]);
    }
}
