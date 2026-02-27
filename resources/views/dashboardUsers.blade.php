@extends('layouts.dashboard')

@section('title', 'Kopiao - Dashboard')

@section('page-title', 'Tableau de bord')

@section('content')
    <!-- Profile Completion Banner -->
    @include('dashboard.partials.profile-banner')

  
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endpush
