@extends('layouts.dashboard')

@section('title', ($article->exists ? 'Modifier' : 'Nouvel').' article - Administration')
@section('page-title', $article->exists ? 'Modifier l\'article' : 'Nouvel article')

@push('styles')
    <style>
        .af-form { max-width: 720px; }
        .af-group { margin-bottom: 20px; }
        .af-group label { display: block; font-weight: 700; color: var(--kp-ink); font-size: var(--kp-fs-base); margin-bottom: 8px; }
        .af-group input[type="text"],
        .af-group textarea { width: 100%; padding: 12px 14px; border: 1.5px solid var(--kp-border); border-radius: 12px; font-size: var(--kp-fs-base); background: #fff; }
        .af-group input[type="text"]:focus,
        .af-group textarea:focus { outline: none; border-color: var(--kp-blue); box-shadow: 0 0 0 3px var(--kp-blue-soft); }
        .af-group textarea { min-height: 260px; resize: vertical; }
        .af-err { color: #e02c18; font-size: var(--kp-fs-2xs); font-weight: 600; margin-top: 6px; display: block; }
        .af-cover-preview { max-width: 220px; border-radius: 12px; margin-bottom: 10px; display: block; }
        .af-check { display: flex; align-items: center; gap: 10px; }
        .af-actions { display: flex; gap: 10px; margin-top: 26px; }
        .af-btn { display: inline-flex; align-items: center; gap: 8px; height: 46px; padding: 0 24px; border-radius: var(--kp-radius-pill); font-weight: 700; font-size: var(--kp-fs-base); text-decoration: none; border: none; cursor: pointer; }
        .af-btn--save { background: var(--kp-blue); color: #fff; }
        .af-btn--save:hover { background: var(--kp-blue-darker); color: #fff; }
        .af-btn--cancel { background: var(--kp-surface); color: var(--kp-ink); }
    </style>
@endpush

@section('content')
    <form class="af-form" method="POST"
          action="{{ $article->exists ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if ($article->exists)
            @method('PUT')
        @endif

        <div class="af-group">
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required>
            @error('title')<span class="af-err">{{ $message }}</span>@enderror
        </div>

        <div class="af-group">
            <label for="excerpt">Résumé <span style="font-weight:400;color:var(--kp-muted);">(affiché dans la liste et utilisé pour le référencement)</span></label>
            <input type="text" id="excerpt" name="excerpt" maxlength="255" value="{{ old('excerpt', $article->excerpt) }}">
            @error('excerpt')<span class="af-err">{{ $message }}</span>@enderror
        </div>

        <div class="af-group">
            <label for="content">Contenu</label>
            <textarea id="content" name="content" required>{{ old('content', $article->content) }}</textarea>
            @error('content')<span class="af-err">{{ $message }}</span>@enderror
        </div>

        <div class="af-group">
            <label for="cover">Image de couverture</label>
            @if ($article->cover_path)
                <img src="{{ asset('storage/' . $article->cover_path) }}" alt="" class="af-cover-preview">
            @endif
            <input type="file" id="cover" name="cover" accept="image/*">
            @error('cover')<span class="af-err">{{ $message }}</span>@enderror
        </div>

        <div class="af-group af-check">
            <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
            <label for="is_published" style="margin:0;">Publier l'article</label>
        </div>

        <div class="af-actions">
            <button type="submit" class="af-btn af-btn--save"><i class="fas fa-save"></i> Enregistrer</button>
            <a href="{{ route('admin.articles') }}" class="af-btn af-btn--cancel">Annuler</a>
        </div>
    </form>
@endsection
