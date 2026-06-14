@extends('layouts.dashboard')

@section('title', 'Matières - Administration')
@section('page-title', 'Matières')

@push('styles')
    <style>
        .sm-head { margin-bottom: 18px; }
        .sm-head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .sm-head p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }

        .sm-add { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 18px; }
        .sm-add input { flex: 1; min-width: 200px; height: 46px; padding: 0 16px; border: 1.5px solid var(--kp-border); border-radius: 12px; font-size: var(--kp-fs-base); background: #fff; }
        .sm-add input:focus { outline: none; border-color: var(--kp-blue); box-shadow: 0 0 0 3px var(--kp-blue-soft); }
        .sm-add button { height: 46px; padding: 0 22px; border: none; border-radius: var(--kp-radius-pill); background: var(--kp-blue); color: #fff; font-weight: 700; font-size: var(--kp-fs-base); cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: background .2s; }
        .sm-add button:hover { background: var(--kp-blue-darker); }
        .sm-err { color: #fff; background: #e02c18; padding: 9px 14px; border-radius: 10px; font-size: var(--kp-fs-sm); font-weight: 600; width: 100%; }

        .sm-search { position: relative; margin-bottom: 16px; max-width: 360px; }
        .sm-search input { width: 100%; height: 46px; padding: 0 16px 0 44px; border: 1.5px solid var(--kp-border); border-radius: 12px; font-size: var(--kp-fs-base); background: #fff; }
        .sm-search input:focus { outline: none; border-color: var(--kp-blue); box-shadow: 0 0 0 3px var(--kp-blue-soft); }
        .sm-search i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--kp-muted); }
        .sm-noresult { display: none; text-align: center; padding: 30px; color: var(--kp-muted); }

        .sm-list { display: flex; flex-direction: column; gap: 8px; }
        .sm-item { display: flex; align-items: center; gap: 14px; background: #fff; border: 1px solid var(--kp-border); border-radius: 12px; padding: 12px 16px; transition: border-color .2s; }
        .sm-item:hover { border-color: var(--kp-blue); }
        .sm-item__ico { width: 40px; height: 40px; border-radius: 11px; background: var(--kp-blue-soft); color: var(--kp-blue); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .sm-item__main { flex: 1; min-width: 0; }
        .sm-item__name { font-weight: 700; color: var(--kp-ink); font-size: var(--kp-fs-base); }
        .sm-item__meta { color: var(--kp-muted); font-size: var(--kp-fs-2xs); display: flex; gap: 14px; margin-top: 2px; flex-wrap: wrap; }
        .sm-item__actions { display: flex; gap: 8px; flex-shrink: 0; }
        .sm-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; height: 36px; padding: 0 14px; border-radius: 9px; font-size: var(--kp-fs-2xs); font-weight: 700; cursor: pointer; border: none; }
        .sm-btn--edit { background: var(--kp-surface); color: var(--kp-ink); }
        .sm-btn--edit:hover { background: var(--kp-blue); color: #fff; }
        .sm-btn--del { background: #fee2e2; color: #e02c18; }
        .sm-btn--del:hover { background: #e02c18; color: #fff; }
        @media (max-width: 520px) {
            .sm-item { flex-wrap: wrap; }
            .sm-item__actions { width: 100%; }
            .sm-item__actions .sm-btn, .sm-item__actions form { flex: 1; }
            .sm-item__actions form .sm-btn { width: 100%; }
        }

        .sm-empty { text-align: center; padding: 50px 20px; color: var(--kp-muted); }

        .sm-modal { display: none; position: fixed; inset: 0; background: rgba(11, 18, 32, .5); z-index: 3600; align-items: center; justify-content: center; padding: 20px; }
        .sm-modal.active { display: flex; }
        .sm-modal__box { background: #fff; border-radius: 18px; padding: 26px; max-width: 420px; width: 100%; box-shadow: 0 24px 60px rgba(0, 0, 0, .25); }
        .sm-modal__box h3 { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 16px; }
        .sm-modal__box input { width: 100%; height: 46px; padding: 0 14px; border: 1.5px solid var(--kp-border); border-radius: 11px; font-size: var(--kp-fs-base); margin-bottom: 16px; }
        .sm-modal__box input:focus { outline: none; border-color: var(--kp-blue); }
        .sm-modal__buttons { display: flex; gap: 10px; }
        .sm-modal__btn { flex: 1; padding: 11px; border-radius: 10px; font-weight: 600; font-size: var(--kp-fs-base); cursor: pointer; border: none; }
        .sm-modal__btn.cancel { background: var(--kp-surface); color: var(--kp-ink); }
        .sm-modal__btn.save { background: var(--kp-blue); color: #fff; }
    </style>
@endpush

@section('content')
    <div class="sm-head">
        <h2>Gestion des matières</h2>
        <p>{{ count($subjects) }} matière(s) au catalogue de la plateforme.</p>
    </div>

    <form method="POST" action="{{ route('admin.subjects.store') }}" class="sm-add">
        @csrf
        <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Nom de la nouvelle matière…" required>
        <button type="submit"><i class="fas fa-plus"></i> Ajouter</button>
        @error('nom')<span class="sm-err">{{ $message }}</span>@enderror
    </form>

    @if (count($subjects) > 0)
        <div class="sm-search">
            <i class="fas fa-search"></i>
            <input type="text" id="smSearch" placeholder="Rechercher une matière…">
        </div>

        <div class="sm-list">
            @foreach ($subjects as $subject)
                <div class="sm-item" data-name="{{ strtolower($subject->nom) }}">
                    <div class="sm-item__ico"><i class="fas fa-book"></i></div>
                    <div class="sm-item__main">
                        <div class="sm-item__name">{{ $subject->nom }}</div>
                        <div class="sm-item__meta">
                            <span><i class="fas fa-chalkboard-teacher"></i> {{ $subject->users_count }} tuteur(s)</span>
                            <span><i class="fas fa-bullhorn"></i> {{ $subject->annonces_count }} annonce(s)</span>
                        </div>
                    </div>
                    <div class="sm-item__actions">
                        <button type="button" class="sm-btn sm-btn--edit" onclick="openSubjectEdit({{ $subject->id }}, '{{ addslashes($subject->nom) }}')"><i class="fas fa-edit"></i> Modifier</button>
                        <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST"
                              onsubmit="return kpConfirmDelete(event, this, {title: 'Supprimer cette matière ?', text: 'Cette action est irréversible.', confirmText: 'Oui, supprimer'});">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="sm-btn sm-btn--del"><i class="fas fa-trash"></i> Supprimer</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="sm-noresult" id="smNoResult">Aucune matière ne correspond à la recherche.</div>
    @else
        <div class="sm-empty"><i class="fas fa-book" style="font-size: 50px; color: var(--kp-border); display: block; margin-bottom: 12px;"></i>Aucune matière. Ajoutez-en une ci-dessus.</div>
    @endif

    {{-- Modal édition --}}
    <div class="sm-modal" id="subjectEditModal">
        <div class="sm-modal__box">
            <h3>Modifier la matière</h3>
            <form method="POST" id="subjectEditForm" action="">
                @csrf
                @method('PUT')
                <input type="text" name="nom" id="subjectEditInput" required>
                <div class="sm-modal__buttons">
                    <button type="button" class="sm-modal__btn cancel" onclick="closeSubjectEdit()">Annuler</button>
                    <button type="submit" class="sm-modal__btn save">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openSubjectEdit(id, nom) {
            const f = document.getElementById('subjectEditForm');
            f.action = '{{ url('admin/matieres') }}/' + id;
            document.getElementById('subjectEditInput').value = nom;
            document.documentElement.style.overflow = 'hidden';
            document.body.style.overflow = 'hidden';
            document.getElementById('subjectEditModal').classList.add('active');
        }
        function closeSubjectEdit() {
            document.getElementById('subjectEditModal').classList.remove('active');
            document.documentElement.style.overflow = '';
            document.body.style.overflow = '';
        }
        document.getElementById('subjectEditModal').addEventListener('click', function (e) { if (e.target === this) closeSubjectEdit(); });

        (function () {
            const input = document.getElementById('smSearch');
            const items = Array.from(document.querySelectorAll('.sm-item[data-name]'));
            const noRes = document.getElementById('smNoResult');
            if (input) {
                input.addEventListener('input', function () {
                    const q = this.value.toLowerCase().trim();
                    let visible = 0;
                    items.forEach(it => {
                        const match = it.dataset.name.includes(q);
                        it.style.display = match ? '' : 'none';
                        if (match) visible++;
                    });
                    if (noRes) noRes.style.display = visible === 0 ? 'block' : 'none';
                });
            }
        })();
        @if ($errors->has('nom') && old('_method') !== 'PUT')
            document.addEventListener('DOMContentLoaded', function () { document.querySelector('.sm-add input')?.focus(); });
        @endif
    </script>
@endpush
