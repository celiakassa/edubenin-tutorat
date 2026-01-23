<div class="sessions-container">
    <div class="section-header">
        <h2 class="section-title">Statistiques de la plateforme</h2>
    </div>

    <div class="stats-grid">
        <!-- Graphique 1: Répartition Tuteurs/Étudiants -->
        <div class="stat-card">
            <div class="stat-header">
                <h3>Répartition des utilisateurs</h3>
                <span class="total-users">Total: {{ $stats['totalUsers'] }}</span>
            </div>
            <div class="chart-container">
                <canvas id="usersChart" width="400" height="200"></canvas>
            </div>
            <div class="stat-details">
                <div class="stat-item">
                    <span class="stat-label">👨‍🏫 Tuteurs</span>
                    <span class="stat-value">{{ $stats['tutorsPercentage'] }}%</span>
                    <span class="stat-count">({{ $stats['tutorsCount'] }})</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">👨‍🎓 Étudiants</span>
                    <span class="stat-value">{{ $stats['studentsPercentage'] }}%</span>
                    <span class="stat-count">({{ $stats['studentsCount'] }})</span>
                </div>
            </div>
        </div>

        <!-- Graphique 2: Préférences d'apprentissage des tuteurs -->
        <div class="stat-card">
            <div class="stat-header">
                <h3>Mode d'enseignement des tuteurs</h3>
            </div>
            <div class="chart-container">
                <canvas id="tutorsPreferenceChart" width="400" height="200"></canvas>
            </div>
            <div class="stat-details">
                <div class="stat-item">
                    <span class="stat-label">💻 En ligne</span>
                    <span class="stat-value">{{ $stats['onlineTutors'] }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">🏫 Présentiel</span>
                    <span class="stat-value">{{ $stats['inPersonTutors'] }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">🔀 Hybride</span>
                    <span class="stat-value">{{ $stats['hybridTutors'] }}</span>
                </div>
            </div>
        </div>

        <!-- Graphique 3: Préférences d'apprentissage des étudiants -->
        <div class="stat-card">
            <div class="stat-header">
                <h3>Préférences d'apprentissage des étudiants</h3>
            </div>
            <div class="chart-container">
                <canvas id="studentsPreferenceChart" width="400" height="200"></canvas>
            </div>
            <div class="stat-details">
                <div class="stat-item">
                    <span class="stat-label">💻 En ligne</span>
                    <span class="stat-value">{{ $stats['onlineStudents'] }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">🏫 Présentiel</span>
                    <span class="stat-value">{{ $stats['inPersonStudents'] }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">🔀 Hybride</span>
                    <span class="stat-value">{{ $stats['hybridStudents'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>