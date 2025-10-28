{{-- ==========================
     Page-specific JS
=========================== --}}
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Đăng xuất thành công',
                text: @json(session('success')),
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form');
        const loginBtn = document.getElementById('login-btn');
        const originalText = loginBtn?.textContent || 'Đăng nhập';

        const showAlert = (icon, title, text, timer = null) => {
            Swal.fire({
                icon,
                title,
                text,
                timer,
                showConfirmButton: timer ? false : true
            });
        };

        // ---------- Kiểm tra dữ liệu client ----------
        form?.addEventListener('submit', e => {
            const login = document.getElementById('login')?.value.trim();
            const password = document.getElementById('password')?.value.trim();

            if (!login || !password) {
                e.preventDefault();
                const msg = !login && !password ?
                    'Vui lòng nhập tên đăng nhập và mật khẩu.' :
                    !login ? 'Vui lòng nhập tên đăng nhập.' : 'Vui lòng nhập mật khẩu.';
                showAlert('warning', 'Thiếu thông tin', msg);
                return;
            }

            loginBtn.disabled = true;
            loginBtn.textContent = 'Đang đăng nhập...';
        });

        // ---------- Thông báo Session ----------
        @if (session('error'))
            showAlert('error', 'Đăng nhập thất bại', @json(session('error')));
            loginBtn.disabled = false;
            loginBtn.textContent = originalText;
        @endif

        @if (session('message'))
            showAlert('success', 'Thành công', @json(session('message')), 2000);
        @endif

        // ---------- Giới hạn / Đếm ngược ----------
        @if ($errors->has('throttle'))
            let countdown = {{ $errors->first('throttle') }};
            loginBtn.disabled = true;

            Swal.fire({
                icon: 'error',
                title: 'Quá nhiều lần thử đăng nhập',
                html: `Bạn đã nhập sai thông tin quá nhiều lần.<br>
                   Vui lòng thử lại sau <b id="swal-countdown">${countdown}</b> giây.`,
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    const interval = setInterval(() => {
                        countdown--;
                        document.getElementById('swal-countdown').textContent = countdown;
                        loginBtn.textContent =
                        `Vui lòng thử lại sau ${countdown} giây...`;

                        if (countdown <= 0) {
                            clearInterval(interval);
                            loginBtn.disabled = false;
                            loginBtn.textContent = originalText;
                            Swal.close();
                        }
                    }, 1000);
                }
            });
        @endif
    });
</script>
