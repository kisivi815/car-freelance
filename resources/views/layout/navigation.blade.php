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

                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Components</span>
                    </a>

                    <ul class="submenu ">

                        <li class="submenu-item  ">
                            <a href="component-accordion.html" class="submenu-link">Accordion</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-alert.html" class="submenu-link">Alert</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-badge.html" class="submenu-link">Badge</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-breadcrumb.html" class="submenu-link">Breadcrumb</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-button.html" class="submenu-link">Button</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-card.html" class="submenu-link">Card</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-carousel.html" class="submenu-link">Carousel</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-collapse.html" class="submenu-link">Collapse</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-dropdown.html" class="submenu-link">Dropdown</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-list-group.html" class="submenu-link">List Group</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-modal.html" class="submenu-link">Modal</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-navs.html" class="submenu-link">Navs</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-pagination.html" class="submenu-link">Pagination</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-placeholder.html" class="submenu-link">Placeholder</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-progress.html" class="submenu-link">Progress</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-spinner.html" class="submenu-link">Spinner</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-toasts.html" class="submenu-link">Toasts</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="component-tooltip.html" class="submenu-link">Tooltip</a>

                        </li>

                    </ul>


                </li>

                

                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Layouts</span>
                    </a>

                    <ul class="submenu ">

                        <li class="submenu-item  ">
                            <a href="layout-default.html" class="submenu-link">Default Layout</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="layout-vertical-1-column.html" class="submenu-link">1 Column</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="layout-vertical-navbar.html" class="submenu-link">Vertical Navbar</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="layout-rtl.html" class="submenu-link">RTL Layout</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="layout-horizontal.html" class="submenu-link">Horizontal Menu</a>

                        </li>

                    </ul>


                </li>
                <li class="sidebar-item {{ Request::routeIs('quick-sale') ? 'active' : '' }}">
                    <a href="{{ route('quick-sale') }}" class='sidebar-link'>
                    <i class=""></i>
                        <span>Quick Sale</span>
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
