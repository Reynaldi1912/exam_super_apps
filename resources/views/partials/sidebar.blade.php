<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
     @if(Session::get('role') == 'admin')
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Exam Apps</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        EXAM
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="/exam-data">
            <i class="fas fa-fw fa-book"></i>
            <span>Datas Exam</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/list-bank">
            <i class="fas fa-fw fa-paperclip"></i>
            <span>Question Bank</span></a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading">
        ACCESS
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="/grouping">
        <i class="fas fa-fw fa-users"></i>
            <span>Grouping</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/users">
        <i class="fas fa-fw fa-user"></i>
            <span>Users</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="sidebar-heading">
        Results
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="/list-results">
            <i class="fas fa-fw fa-star"></i>
            <span>Exam Results</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    @else
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Exam Apps</div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
        
    @endif

</ul>