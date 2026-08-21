@extends('layouts.welcomeLayout')

@section('title', $article->title.' — Blog Kopiao')
@section('meta_description', $metaDescription)

@section('content')
<style>
    .article-page { background: var(--kp-surface); padding: 40px 0 70px; }
    .article-wrap { max-width: 760px; margin: 0 auto; padding: 0 16px; }
    .article-back { color: var(--kp-blue); font-weight: 600; font-size: .9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 22px; }
    .article-back:hover { text-decoration: underline; }
    .article-date { color: var(--kp-muted); font-size: .85rem; margin: 0 0 10px; }
    .article-title { font-family: var(--kp-font-title); font-weight: 800; font-size: clamp(1.7rem, 1.2rem + 2vw, 2.4rem); color: var(--kp-ink); margin: 0 0 24px; }
    .article-cover { width: 100%; border-radius: var(--kp-radius); margin-bottom: 28px; max-height: 420px; object-fit: cover; }
    .article-video { width: 100%; border-radius: var(--kp-radius); margin-bottom: 28px; background: #000; }
    .article-body { background: var(--kp-white); border: 1px solid var(--kp-border); border-radius: var(--kp-radius); box-shadow: var(--kp-shadow-sm); padding: 32px; color: var(--kp-text); line-height: 1.8; }
    .article-body p { margin: 0 0 18px; }
</style>

<div class="article-page">
    <div class="article-wrap">
        <a href="{{ route('blog.index') }}" class="article-back"><i class="bi bi-arrow-left"></i> Retour au blog</a>

        <p class="article-date">{{ $article->published_at?->translatedFormat('d M Y') }}</p>
        <h1 class="article-title">{{ $article->title }}</h1>

        @if ($article->cover_path)
            <img src="{{ asset('storage/' . $article->cover_path) }}" alt="{{ $article->title }}" class="article-cover">
        @endif

        @if ($article->video_path)
            <video src="{{ asset('storage/' . $article->video_path) }}" class="article-video" controls></video>
        @endif

        <div class="article-body">
            {!! nl2br(e($article->content)) !!}
        </div>
    </div>
</div>
@endsection
