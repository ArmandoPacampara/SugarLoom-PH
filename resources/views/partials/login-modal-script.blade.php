<script>
    const loginModal = document.getElementById('loginModal');

    function openLoginModal() {
        if (!loginModal) return;
        loginModal.classList.add('is-open');
        loginModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        setTimeout(function() {
            document.getElementById('modal-email')?.focus();
        }, 50);
    }

    function closeLoginModal() {
        if (!loginModal) return;
        loginModal.classList.remove('is-open');
        loginModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
    }

    document.querySelectorAll('[data-login-open]').forEach(function(trigger) {
        trigger.addEventListener('click', openLoginModal);
    });

    document.querySelectorAll('[data-login-close]').forEach(function(trigger) {
        trigger.addEventListener('click', closeLoginModal);
    });

    loginModal?.addEventListener('click', function(event) {
        if (event.target === loginModal) {
            closeLoginModal();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeLoginModal();
        }
    });

    if (loginModal?.classList.contains('is-open')) {
        document.body.classList.add('modal-open');
    }
</script>
