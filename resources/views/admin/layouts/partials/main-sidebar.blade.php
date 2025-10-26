<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">JobFinder Admin</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">JF</a>
        </div>

        <ul class="sidebar-menu">

            {{-- ================== 1. TỔNG QUAN ================== --}}
            <li class="menu-header">Tổng quan</li>
            <li><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i>
                    <span>Bảng
                        điều khiển</span></a></li>
            <li><a href="#"><i class="fas fa-bell"></i> <span>Thông báo hệ thống</span></a></li>
            <li><a href="#"><i class="fas fa-clipboard-list"></i> <span>Nhật ký hoạt động</span></a></li>
            <li><a href="#"><i class="fas fa-history"></i> <span>Backup & Khôi phục</span></a></li>

            {{-- ================== 2. CÔNG VIỆC ================== --}}
            <li class="menu-header">Công việc & Tuyển dụng</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-briefcase"></i> <span>Tin tuyển dụng</span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.job_categories.index') }}">Danh mục công việc</a></li>
                    <li><a href="{{ route('admin.job_roles.index') }}">Chức vụ</a></li>
                    <li><a href="{{ route('admin.job_experiences.index') }}">Kinh nghiệm</a></li>
                    <li><a href="{{ route('admin.education.index') }}">Trình độ học vấn</a></li>
                    <li><a href="{{ route('admin.job_types.index') }}">Loại hình công việc</a></li>
                    <li><a href="{{ route('admin.salary_types.index') }}">Hình thức lương</a></li>
                    <li><a href="#">Ngành nghề kinh doanh</a></li>
                    <li><a href="#">Loại hình tổ chức</a></li>
                    <li><a href="{{ route('admin.companies.index') }}">Công ty</a></li>
                    <li><a href="{{ route('admin.cities.index') }}">Thành phố</a></li>
                    <li><a href="{{ route('admin.states.index') }}">Tỉnh</a></li>
                    <li><a href="{{ route('admin.countries.index') }}">Quốc gia</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-tasks"></i> <span>Quản lý Job</span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.jobs.index') }}">Tin tuyển dụng</a></li>
                    <li><a href="{{ route('admin.job_tags.index') }}">Job Tags</a></li>
                    <li><a href="{{ route('admin.job_skills.index') }}">Kỹ năng công việc</a></li>
                    <li><a href="{{ route('admin.job_benefits.index') }}">Phúc lợi công việc</a></li>
                    <li><a href="{{ route('admin.benefits.index') }}">Phúc lợi</a></li>
                    <li><a href="{{ route('admin.skills.index') }}">Kỹ năng</a></li>
                    <li><a href="{{ route('admin.tags.index') }}">Tags</a></li>
                    <li><a href="{{ route('admin.languages.index') }}">Ngôn ngữ</a></li>
                    <li><a href="{{ route('admin.professions.index') }}">Nghề nghiệp</a></li>
                </ul>
            </li>

            {{-- ================== 3. ỨNG VIÊN ================== --}}
            <li class="menu-header">Ứng viên</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-user-graduate"></i> <span>Hồ sơ & Ứng
                        viên</span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Tất cả ứng viên</a></li>
                    <li><a href="#">Hồ sơ tải lên</a></li>
                    <li><a href="#">Ứng viên nổi bật</a></li>
                    <li><a href="#">Đánh giá / Điểm năng lực</a></li>
                    <li><a href="#">Hồ sơ bị khóa</a></li>
                    <li><a href="#">Trạng thái tuyển dụng</a></li>
                </ul>
            </li>

            {{-- ================== 4. NHÀ TUYỂN DỤNG ================== --}}
            <li class="menu-header">Nhà tuyển dụng</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-building"></i> <span>Quản lý công
                        ty</span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.company_about.company_profile.index') }}">Thông tin công ty</a></li>
                    <li><a href="{{ route('admin.company_about.company_team_member.index') }}">Đội ngũ</a></li>
                    <li><a href="{{ route('admin.company_about.why_choose_us.index') }}">Tại sao chọn chúng tôi</a></li>
                    <li><a href="{{ route('admin.pricing.pricing_plan.index') }}">Gói dịch vụ tuyển dụng</a></li>
                    <li><a href="#">Đánh giá công ty</a></li>
                    <li><a href="#">Trạng thái hoạt động</a></li>
                </ul>
            </li>

            {{-- ================== 5. ỨNG DỤNG HỆ THỐNG ================== --}}
            <li class="menu-header">Ứng dụng hệ thống</li>
            <li><a href="#"><i class="fas fa-comments"></i> <span>Chat Realtime</span></a></li>
            <li><a href="#"><i class="fas fa-calendar-check"></i> <span>Lịch phỏng vấn</span></a></li>
            <li><a href="#"><i class="fas fa-envelope-open-text"></i> <span>Quản lý Email Queue</span></a></li>
            <li><a href="#"><i class="fas fa-credit-card"></i> <span>Thanh toán & Hóa đơn</span></a></li>
            <li><a href="#"><i class="fas fa-bullhorn"></i> <span>Chiến dịch Marketing</span></a></li>

            {{-- ================== 6. NỘI DUNG WEBSITE ================== --}}
            <li class="menu-header">Nội dung Website</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-edit"></i> <span>Trang & Bài
                        viết</span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.content.blog.index') }}">Blog / Tin tức</a></li>
                    <li><a href="#">Trang tĩnh</a></li>
                    <li><a href="{{ route('admin.content.hero.index') }}">Banner / Slider</a></li>
                    <li><a href="#">Câu hỏi thường gặp (FAQ)</a></li>
                    <li><a href="#">Lời chứng thực</a></li>
                    <li><a href="#">SEO & Metadata</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-cogs"></i> <span>Quản lý nội dung</span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.content.counter.index') }}">Bộ đếm</a></li>
                    <li><a href="{{ route('admin.content.learn_more.index') }}">Tìm hiểu thêm</a></li>
                </ul>
            </li>
            <li><a href="#"><i class="fas fa-bullseye"></i> <span>Landing Page</span></a></li>

            {{-- ================== 7. NGƯỜI DÙNG ================== --}}
            <li class="menu-header">Người dùng & Phân quyền</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-users-cog"></i> <span>Tài khoản hệ
                        thống</span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Quản lý Admin</a></li>
                    <li><a href="#">Phân quyền (Roles)</a></li>
                    <li><a href="#">Quyền chi tiết (Permissions)</a></li>
                    <li><a href="#">Nhật ký truy cập</a></li>
                    <li><a href="#">2FA & Bảo mật</a></li>
                </ul>
            </li>

            {{-- ================== 8. CẤU HÌNH & HỆ THỐNG ================== --}}
            <li class="menu-header">Cấu hình hệ thống</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-cogs"></i> <span>Cấu hình</span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Cài đặt chung</a></li>
                    <li><a href="#">SMTP & Email</a></li>
                    <li><a href="#">Cấu hình Cache</a></li>
                    <li><a href="#">Bảo mật</a></li>
                    <li><a href="#">Tích hợp bên thứ 3</a></li>
                    <li><a href="#">Quản lý Logs hệ thống</a></li>
                </ul>
            </li>

            {{-- ================== 9. PHÂN TÍCH & GIÁM SÁT ================== --}}
            <li class="menu-header">Phân tích & Báo cáo</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-chart-pie"></i> <span>Thống kê & Báo
                        cáo</span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Thống kê việc làm</a></li>
                    <li><a href="#">Thống kê ứng viên</a></li>
                    <li><a href="#">Nguồn traffic</a></li>
                    <li><a href="#">Hiệu suất máy chủ</a></li>
                    <li><a href="#">Phân tích hành vi người dùng</a></li>
                    <li><a href="#">Báo cáo doanh thu</a></li>
                </ul>
            </li>

            {{-- ================== 10. DEVELOPER TOOLS ================== --}}
            <li class="menu-header">Developer Tools</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-tools"></i> <span>Công cụ cho
                        Dev</span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Clear Cache</a></li>
                    <li><a href="#">Optimize Autoload</a></li>
                    <li><a href="#">Run Migrations</a></li>
                    <li><a href="#">Seed Database</a></li>
                    <li><a href="#">Queue Monitor</a></li>
                    <li><a href="#">Event Listener Logs</a></li>
                    <li><a href="#">Tinker Console</a></li>
                    <li><a href="#">Test API Endpoint</a></li>
                    <li><a href="#">System Health Check</a></li>
                    <li><a href="#">Storage Cleaner</a></li>
                </ul>
            </li>

            {{-- ================== 11. HỖ TRỢ & TRỢ GIÚP ================== --}}
            <li class="menu-header">Hỗ trợ</li>
            <li><a href="#"><i class="fas fa-life-ring"></i> <span>Trung tâm hỗ trợ</span></a></li>
            <li><a href="#"><i class="fas fa-file-alt"></i> <span>Tài liệu kỹ thuật</span></a></li>
            <li><a href="#"><i class="fas fa-code-branch"></i> <span>Phiên bản & Cập nhật</span></a></li>
            <li><a href="#"><i class="fas fa-comments-dollar"></i> <span>Phản hồi người dùng</span></a></li>
        </ul>

        {{-- ================== ĐĂNG XUẤT ================== --}}
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <form action="{{ route('admin.profile.logouts') }}" method="POST" id="logoutForm">
                @csrf
                <button type="button" id="logoutBtn" class="btn btn-danger btn-lg btn-block btn-icon-split shadow-sm">
                    <i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span>
                </button>
            </form>
        </div>
    </aside>
</div>

@push('scripts')
    <script>
        document.getElementById('logoutBtn').addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Xác nhận đăng xuất',
                text: "Bạn có chắc muốn thoát khỏi hệ thống?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Đăng xuất',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });
    </script>
@endpush