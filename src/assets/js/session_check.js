document.addEventListener('DOMContentLoaded', function () {
    fetch('/php/check_session.php')
        .then(res => res.json())
        .then(data => {
            if (data.loggedIn) {
                const loginBtn = document.getElementById('loginBtn');
                const userIcon = document.getElementById('userIcon');
                if (loginBtn) loginBtn.classList.add('hidden');
                if (userIcon) userIcon.classList.remove('hidden');
            }
        });
});
