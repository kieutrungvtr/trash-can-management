
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-category">QUẢN LÝ THÙNG RÁC</li>

        <li class="nav-item">
            <a class="nav-link" href="/admin/trash/create_qr">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">TẠO QR CODE</span>
                <i class="menu-arrow"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/admin/trash/list">
                <i class="mdi mdi-delete menu-icon"></i>
                <span class="menu-title">DANH SÁCH</span>
                <i class="menu-arrow"></i>
            </a>
        </li>

        <li class="nav-item nav-category">Thống kê</li>

        <li class="nav-item">
            <a class="nav-link" href="/admin/stats/dashboard">
                <i class="menu-icon mdi mdi-view-dashboard"></i>
                <span class="menu-title">{{__('Tổng quan')}}</span>
                <i class="menu-arrow"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/admin/stats/trash_group">
                <i class="menu-icon mdi mdi-chart-line"></i>
                <span class="menu-title">{{__('Chart 1')}}</span>
                <i class="menu-arrow"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/admin/stats/trash_group_type">
                <i class="menu-icon mdi mdi-chart-line"></i>
                <span class="menu-title">{{__('Chart 2')}}</span>
                <i class="menu-arrow"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/admin/stats/line_week">
                <i class="menu-icon mdi mdi-chart-line"></i>
                <span class="menu-title">{{__('Chart 3')}}</span>
                <i class="menu-arrow"></i>
            </a>
        </li>
        <li class="nav-item nav-category">Thu thập dữ liệu</li>
        <li class="nav-item">
            <a class="nav-link" href="/admin/data/list">
                <i class="menu-icon mdi mdi-file-excel"></i>
                <span class="menu-title">{{__('Danh sách dữ liệu')}}</span>
                <i class="menu-arrow"></i>
            </a>
        </li>
    </ul>
</nav>
