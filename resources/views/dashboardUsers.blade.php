@extends('layouts.dashboard')

@section('title', 'Kopiao - Dashboard')

@section('page-title', 'Tableau de bord')

@section('content')
    <!-- Profile Completion Banner -->
    @include('dashboard.partials.profile-banner')

    <!-- Dashboard Stats -->
    @include('dashboard.partials.stats')

    <!-- Platform Statistics -->
    @include('dashboard.partials.platform-stats')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique 1: Répartition Tuteurs/Étudiants
        const usersCtx = document.getElementById('usersChart')?.getContext('2d');
        if (usersCtx) {
            new Chart(usersCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Tuteurs', 'Étudiants'],
                    datasets: [{
                        data: [{{ $stats['tutorsCount'] }}, {{ $stats['studentsCount'] }}],
                        backgroundColor: ['#4f46e5', '#10b981'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Graphique 2: Préférences des tuteurs
        const tutorsPreferenceCtx = document.getElementById('tutorsPreferenceChart')?.getContext('2d');
        if (tutorsPreferenceCtx) {
            new Chart(tutorsPreferenceCtx, {
                type: 'bar',
                data: {
                    labels: ['En ligne', 'Présentiel', 'Hybride'],
                    datasets: [{
                        label: 'Tuteurs',
                        data: [{{ $stats['onlineTutors'] }}, {{ $stats['inPersonTutors'] }}, {{ $stats['hybridTutors'] }}],
                        backgroundColor: ['#3b82f6', '#ef4444', '#f59e0b'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // Graphique 3: Préférences des étudiants
        const studentsPreferenceCtx = document.getElementById('studentsPreferenceChart')?.getContext('2d');
        if (studentsPreferenceCtx) {
            new Chart(studentsPreferenceCtx, {
                type: 'bar',
                data: {
                    labels: ['En ligne', 'Présentiel', 'Hybride'],
                    datasets: [{
                        label: 'Étudiants',
                        data: [{{ $stats['onlineStudents'] }}, {{ $stats['inPersonStudents'] }}, {{ $stats['hybridStudents'] }}],
                        backgroundColor: ['#3b82f6', '#ef4444', '#f59e0b'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush