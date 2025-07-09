document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Login Modal
    const loginBtn = document.getElementById('loginBtn');
    const loginModal = document.getElementById('loginModal');
    const closeModal = document.getElementById('closeModal');
    if (loginBtn && loginModal && closeModal) {
        loginBtn.addEventListener('click', () => loginModal.classList.remove('hidden'));
        closeModal.addEventListener('click', () => loginModal.classList.add('hidden'));
        loginModal.addEventListener('click', (e) => {
            if (e.target === loginModal) {
                loginModal.classList.add('hidden');
            }
        });
    }

    // Form Validation + Xử lý submit login
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            let isValid = true;
            const inputs = loginForm.querySelectorAll('input[required]');
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('border-red-500');
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            if (!isValid) {
                alert('Vui lòng điền đầy đủ thông tin bắt buộc');
                return;
            }

            const formData = new FormData(loginForm);
            fetch(loginForm.action, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Đăng nhập lỗi:', error);
                alert('Có lỗi xảy ra khi đăng nhập');
            });
        });
    }

    // Active menu item theo trang hiện tại
    const currentPage = window.location.pathname.split('/').pop();
    document.querySelectorAll('nav a').forEach(link => {
        const linkPage = link.getAttribute('href').split('/').pop();
        if (linkPage === currentPage) {
            link.classList.add('active');
        }
    });
});

// Typed.js chạy chữ
var typed = new Typed(".text", {
    strings: [
        "Hành trình sức khỏe của bạn bắt đầu từ đây",
        "Cùng HealthFit chăm sóc bản thân",
        "Sống khỏe mạnh và tràn đầy năng lượng"
    ],
    typeSpeed: 70,
    backSpeed: 30,
    backDelay: 2000,
    loop: true
});

// Nút bắt đầu ngay → measurement.html
document.getElementById('startBtn')?.addEventListener('click', () => {
    window.location.href = 'measurement.html';
});

// Nút startMeasurementBtn → measurement.html
document.getElementById('startMeasurementBtn')?.addEventListener('click', (e) => {
    e.preventDefault();
    window.location.href = 'measurement.html';
});

