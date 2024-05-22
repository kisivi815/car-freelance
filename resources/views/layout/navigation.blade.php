<script src="{{ asset('static/js/initTheme.js') }}"></script>
<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">

                </div>
                <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ Request::routeIs('dashboard') ? 'active' : '' }} ">
                    <a href="{{route('dashboard')}}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::routeIs('quick-sale') ? 'active' : '' }}">
                    <a href="{{ route('quick-sale') }}" class='sidebar-link'>
                        <i class=""></i>
                        <span>Quick Sale</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::routeIs('view-sale') ? 'active' : '' }}">
                    <a href="{{ route('view-sale') }}" class='sidebar-link'>
                        <i class=""></i>
                        <span>View Sale</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::routeIs('view-stock') ? 'active' : '' }}">
                    <a href="{{ route('view-stock') }}" class='sidebar-link'>
                        <i class=""></i>
                        <span>View Stock</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::routeIs('transfer-stock') ? 'active' : '' }}">
                    <a href="{{ route('transfer-stock') }}" class='sidebar-link'>
                        <i class=""></i>
                        <span>Transfer Stock</span>
                    </a>
                </li>
                <li class="sidebar-item ">
                    <a href="{{ route('logout') }}" class='sidebar-link'>
                        <i class="bi bi-power"></i>
                        <span>Logout</span>
                    </a>
                </li>
        </div>
    </div>
</div>