<div class="profile-banner">
    <div class="profile-banner-content">
        <div class="profile-banner-icon">
            <i class="fas fa-user-edit"></i>
        </div>
        <div class="profile-banner-text">
            <h3>Complétez votre profil</h3>
            <p>Votre profil est complété à {{ $profileCompletion }}%. Ajoutez plus d'informations pour améliorer votre visibilité.</p>
            <div class="progress-bar" style="background: #e0e0e0; border-radius: 5px; height: 20px; width: 100%;">
                <div class="progress-bar-fill"
                    style="background: {{ $profileCompletion < 100 ? '#f44336' : '#4caf50' }};
                    width: {{ $profileCompletion }}%;
                    height: 100%;
                    border-radius: 5px;">
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('CompleterProfilUser.edit') }}" class="btn-complete-profile" style="text-decoration: none;">
        <i class="fas fa-pencil-alt"></i>
        Compléter mon profil
    </a>
</div>