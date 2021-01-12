<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.manager') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ trans('admin.hello') }} {{ Auth::user()->username }}</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ trans('admin.home') }}</span>
        </a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.manager') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ trans('admin.dashboard') }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>{{ trans('admin.charts') }}</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>{{ trans('admin.tables') }}</span></a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
</ul>
