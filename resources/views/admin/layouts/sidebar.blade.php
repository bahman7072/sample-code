<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar style-scroll" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('img/user1-128x128.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">بهمن ایمان علیزاده</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ isActive('dashboard') }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                داشبورد
                            </p>
                        </a>
                    </li>
                    @can('show-users')
                        <li class="nav-item has-treeview {{ isActive(array('users.index', 'users.create', 'users.edit', 'users.permissions'), 'menu-open') }}">
                            <a href="#" class="nav-link {{ isActive(array('users.index', 'users.create', 'users.edit', 'users.permissions')) }}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    کاربران
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link {{ isActive(array('users.index', 'users.create', 'users.edit', 'users.permissions')) }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست کاربران</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @canany(array('show-permissions','show-roles'))
                        <li class="nav-item has-treeview {{ isActive(array('permissions.index', 'permissions.create', 'permissions.edit', 'roles.index', 'roles.create', 'roles.edit'), 'menu-open') }}">
                            <a href="#" class="nav-link {{ isActive(array('permissions.index', 'permissions.create', 'permissions.edit', 'roles.index', 'roles.create', 'roles.edit')) }}">
                                <i class="nav-icon fa fa-user-secret"></i>
                                <p>
                                    بخش اجازه دسترسی
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            @can('show-roles')
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('roles.index') }}" class="nav-link {{ isActive(array('roles.index', 'roles.create', 'roles.edit')) }}">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>همه مقام ها</p>
                                        </a>
                                    </li>
                                </ul>
                            @endcan

                            @can('show-permissions')
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('permissions.index') }}" class="nav-link {{ isActive(array('permissions.index', 'permissions.create', 'permissions.edit')) }}">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>همه دسترسی ها</p>
                                        </a>
                                    </li>
                                </ul>
                            @endcan
                        </li>
                    @endcanany
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>