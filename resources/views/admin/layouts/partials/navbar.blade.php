<nav class="navbar navbar-expand-lg main-navbar">
    {{-- Nút mở sidebar --}}
    <ul class="navbar-nav mr-3">
        <li>
            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        {{-- Nút làm mới cache --}}
        <li>
            <a href="#" class="nav-link nav-link-lg" title="Xóa Cache">
                <i class="fas fa-sync-alt"></i>
            </a>
        </li>
        {{-- Developer Tools: Optimize, Migrate, Seed --}}
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg">
                <i class="fas fa-tools"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-left">
                <a href="#" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> Tối ưu hệ thống (Optimize)
                </a>
                <a href="#" class="dropdown-item has-icon">
                    <i class="fas fa-database"></i> Chạy Migration
                </a>
                <a href="#" class="dropdown-item has-icon">
                    <i class="fas fa-seedling"></i> Seed dữ liệu mẫu
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item has-icon">
                    <i class="fas fa-file-alt"></i> Xem Log hệ thống
                </a>
            </div>
        </li>
    </ul>

    {{-- Phần phải: User dropdown --}}
    <ul class="navbar-nav ml-auto navbar-right">
        {{-- Thông báo --}}
        <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg">
                <i class="far fa-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">
                    Thông báo
                    <div class="float-right">
                        <a href="#">Đánh dấu đã đọc</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-icon bg-primary text-white">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Cập nhật hệ thống mới được triển khai.
                            <div class="time text-primary">Vừa xong</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">Xem tất cả</a>
                </div>
            </div>
        </li>

        {{-- Tài khoản --}}
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="avatar"
                    src="{{ Auth::user()->avatar_url ? asset('uploads/images/' . Auth::user()->avatar_url) : asset('assets/img/avatar/avatar-1.png') }}"
                    class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">
                    Xin chào, {{ Auth::user()->username ?? 'Khách' }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profile.show') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Hồ sơ cá nhân
                </a>
                <a href="{{ route('admin.profile.password.show') }}" class="dropdown-item has-icon">
                    <i class="fas fa-key"></i> Đổi mật khẩu
                </a>
                <a href="#" class="dropdown-item has-icon">
                    <i class="fas fa-history"></i> Lịch sử hoạt động
                </a>
                <a href="#" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Cài đặt tài khoản
                </a>

                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.profile.logouts') }}" class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
                <form id="logout-form" action="{{ route('admin.profile.logouts') }}" method="get" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
