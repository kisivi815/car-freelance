<script src="{{ asset('static/js/initTheme.js') }}"></script>
<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-center align-items-center">
                <div class="logo">
                    <img src="{{ asset('image/logo.jpeg') }}" alt="logo" style="width:100%;height:100%;">
                </div>
                <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                <li class="sidebar-item {{ Request::routeIs('inventory-stock') ? 'active' : '' }}">
                    <a href="{{ route('inventory-stock') }}" class='sidebar-link'>
                        <i class=""></i>
                        <span>Invetory Stock</span>
                    </a>
                </li>
                <li class="sidebar-item {{ (Request::routeIs('view-stock') || Request::routeIs('view-stock-default')) ? 'active' : '' }}">
                    <a href="{{ route('view-stock') }}" class='sidebar-link'>
                        <i class=""></i>
                        <span>View Stock</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::routeIs('quick-booking') ? 'active' : '' }}">
                    <a href="{{ route('quick-booking') }}" class='sidebar-link'>
                        <i class=""></i>
                        <span>Quick Booking</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::routeIs('salesForm') ? 'active' : '' }}">
                    <a href="{{ route('salesForm') }}" class='sidebar-link'>
                        <i class=""></i>
                        <span>Add Sales</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::routeIs('view-sales') ? 'active' : '' }}">
                    <a href="{{ route('view-sales') }}" class='sidebar-link'>
                        <i class=""></i>
                        <span>View Sales</span>
                    </a>
                </li>
                @if (in_array(Auth::user()->role_id,['1']))
                <li class="sidebar-item {{ Request::routeIs('transfer-stock') ? 'active' : '' }}">
                    <a href="{{ route('transfer-stock') }}" class='sidebar-link'>
                        <i class=""></i>
                        <span>Transfer Stock</span>
                    </a>
                </li>
                @endif
                <li class="sidebar-item {{ Request::routeIs('report') ? 'active' : '' }}">
                    <a href="{{ route('report') }}" class='sidebar-link'>
                        <i class=""></i>
                        <span>Report</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::routeIs('upload-car-stock') ? 'active' : '' }}">
                    <a href="{{ route('upload-car-stock') }}" class='sidebar-link'>
                        <i class=""></i>
                        <span>Upload Stock</span>
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