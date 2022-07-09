<nav class="navbar default-layout col-lg-12 col-12 p-0 d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
        </div>
        <div>
            <a class="navbar-brand brand-logo" href="/">
                Trang chủ
            </a>
            <a class="navbar-brand brand-logo-mini" href="/">

            </a>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-sm-block ms-0">
                <h1 class="welcome-text">
                    <span class="text-black fw-bold">
                        <img class="d-inline-block" height="50" width="auto" src="/images/logo/lmca.png" alt="Liên minh châu âu"/>
                        <img class="d-inline-block" height="50" width="auto" src="/images/logo/eu_jule.png" alt="EU JULE"/>
                        <img class="d-inline-block" height="50" width="auto" src="/images/logo/oxfam.png" alt="OXFAM"/>
                        <img class="d-inline-block" height="50" width="auto" src="/images/logo/ueh_university.png" alt="UEH"/>
                    </span>
                </h1>
                <h3 class="welcome-sub-text"></h3>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <h3>@yield('page_title')</h3>
                </a>
            </li>
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false"
                    style="background: white; border-radius: 99px; padding: 10px; border: 1px solid"
                >
                    <h2><strong>&nbsp;{{Auth::user()->user_name}}&nbsp;</strong></h2>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <a class="dropdown-item" href="/admin/logout">
                        <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>
                        Đăng xuất
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
