document.getElementById('newsletterForm')?.addEventListener('submit', function (e) {
    e.preventDefault();

    const emailInput = document.getElementById('newsletterEmail');
    const messageDiv = document.getElementById('newsletterMessage');
    const submitBtn = this.querySelector('button[type="submit"]');
    const email = emailInput.value.trim();

    if (!email || !email.includes('@')) {
        messageDiv.innerHTML = '<span class="text-danger">Veuillez entrer un email valide</span>';
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (submitBtn) submitBtn.disabled = true;

    fetch('/newsletter/subscribe', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken || '',
        },
        body: JSON.stringify({ email }),
    })
        .then(async (response) => {
            const data = await response.json().catch(() => ({}));
            if (!response.ok) {
                const firstError = data.errors ? Object.values(data.errors)[0][0] : null;
                throw new Error(firstError || data.message || 'Une erreur est survenue.');
            }
            messageDiv.innerHTML = `<span class="text-success">${data.message}</span>`;
            emailInput.value = '';
        })
        .catch((error) => {
            messageDiv.innerHTML = `<span class="text-danger">${error.message}</span>`;
        })
        .finally(() => {
            if (submitBtn) submitBtn.disabled = false;
            setTimeout(() => { messageDiv.innerHTML = ''; }, 4000);
        });
});
