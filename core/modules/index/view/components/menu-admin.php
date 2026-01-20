<style>
    /* Premium Sidebar Styles */
    .main-sidebar,
    .left-side {
        background-color: #1e1e2d !important;
    }

    .sidebar-menu {
        font-family: 'Helvetica Neue', 'Segoe UI', Arial, sans-serif;
        font-weight: 400;
    }

    .sidebar-menu .header {
        background: transparent !important;
        color: #6c7b88 !important;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        padding: 20px 20px 10px 20px !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        margin-bottom: 5px;
    }

    .sidebar-menu>li>a {
        border-left: 3px solid transparent;
        padding: 12px 20px;
        color: #aeb9bf;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .sidebar-menu>li:hover>a,
    .sidebar-menu>li.active>a {
        background: #2b2b40 !important;
        /* Lighter navy for active state */
        color: #ffffff !important;
        border-left-color: #f39c12;
        box-shadow: inset 5px 0 0 -2px rgba(243, 156, 18, 0.5);
    }

    .sidebar-menu .treeview-menu {
        background: #151521 !important;
        /* Darker navy for submenu */
        padding-left: 0;
    }

    .sidebar-menu .treeview-menu>li>a {
        padding: 10px 20px 10px 35px;
        color: #8aa4af;
        font-size: 0.9em;
        transition: color 0.2s;
    }

    .sidebar-menu .treeview-menu>li>a:hover {
        color: #ffffff;
        padding-left: 40px;
    }

    /* Icon Styling */
    .sidebar-menu i.menu-icon {
        width: 25px;
        text-align: center;
        margin-right: 5px;
        font-size: 1.1em;
        transition: transform 0.2s ease;
        display: inline-block;
    }

    .sidebar-menu>li:hover i.menu-icon {
        transform: scale(1.15);
    }

    /* Custom Colors */
    .text-premium-yellow {
        color: #f1c40f !important;
        text-shadow: 0 0 10px rgba(241, 196, 15, 0.3);
    }

    .text-premium-orange {
        color: #e67e22 !important;
        text-shadow: 0 0 10px rgba(230, 126, 34, 0.3);
    }

    .text-premium-blue {
        color: #3498db !important;
    }

    /* Pull Right Arrow Animation */
    .sidebar-menu .pull-right-container i {
        transition: transform 0.3s;
    }

    .sidebar-menu .treeview.menu-open>.pull-right-container i {
        transform: rotate(-90deg);
    }
</style>

<ul class="sidebar-menu" data-widget="tree">
    <li class="treeview">
        <a href="#">
            <i class="fa fa-building-o menu-icon text-premium-yellow"></i> <span>EMPRESA</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="index.php?view=sucursal">
                    <i class="fa fa-circle-o text-premium-orange"></i> Nuevo
                </a>
            </li>
        </ul>
    </li>

    <li class="header">USUARIOS - CAJA</li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-user-circle-o menu-icon text-premium-yellow"></i> <span>USUARIOS</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="index.php?view=administrador">
                    <i class="fa fa-users text-premium-orange"></i> Usuarios
                </a>
            </li>
        </ul>
    </li>

    <li class="header">REPORTE EN GENERAL</li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-line-chart menu-icon text-premium-yellow"></i> <span>REPORTES</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="index.php?view=reporte_venta_general">
                    <i class="fa fa-bar-chart text-premium-orange"></i> Ventas por Empresa
                </a>
            </li>
        </ul>
    </li>

    <li class="header">CONFIGURACIÓN</li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-cogs menu-icon text-premium-yellow"></i> <span>CONFIGURACIÓN</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="index.php?view=config">
                    <i class="fa fa-wrench text-premium-orange"></i> Configuración
                </a>
            </li>
        </ul>
    </li>
</ul>