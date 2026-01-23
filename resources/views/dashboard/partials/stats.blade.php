<div class="stats-container">
    <div class="stat-card enhanced-card p-4 rounded-4 shadow-lg bg-white hover:shadow-xl transition-all duration-300">
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-clock text-purple-600"></i>
                Dernière connexion
            </h3>

            <div class="w-10 h-10 flex items-center justify-center bg-purple-100 rounded-full">
                <i class="fas fa-history text-purple-700 text-xl"></i>
            </div>
        </div>

        <!-- Value -->
        <div class="text-3xl font-bold text-gray-900 mb-3 flex items-center gap-2">
            @php $user = auth()->user(); @endphp

            @if ($user && $user->last_login)
                <i class="fas fa-check-circle text-green-500"></i>
                {{ $user->last_login->diffForHumans() }}
            @else
                <i class="fas fa-times-circle text-red-500"></i>
                Jamais connecté
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-3 flex items-center text-sm text-gray-600 gap-2">
            <i class="fas fa-info-circle text-blue-500"></i>
            Informations récentes
        </div>
    </div>
</div>