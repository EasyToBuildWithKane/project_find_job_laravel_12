<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="index-0.html">General Dashboard</a></li>
                    <li><a class="nav-link" href="index.html">Ecommerce Dashboard</a></li>
                </ul>
            </li>

            <li class="menu-header">PAGES</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-puzzle-piece"></i> 
                    <span>Company About</span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.company_about.company_profile.index') }}">Our Company</a></li>
                    <li><a href="{{ route('admin.company_about.company_team_member.index') }}">Our Team</a></li>
                </ul>
            </li>

        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="#" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> DEVELOPER TOOLS
            </a>
        </div>
    </aside>
</div>
