<?php
/**
 * Menu Helper
 * Funciones auxiliares para la generación de menús
 */

/**
 * Renderiza el menú de una sucursal específica
 * @param object $sucursal Objeto con datos de la sucursal
 * @param object $u Usuario actual
 */
function renderSucursalMenu($sucursal, $u)
{
    ?>
    <style>
        /* Premium Sidebar Styles - Admin & Helper Shared Aesthetic */
        .main-sidebar,
        .left-side {
            background-color: #1e1e2d !important;
        }

        .sidebar-menu.premium-sidebar {
            font-family: 'Helvetica Neue', 'Segoe UI', Arial, sans-serif;
            font-weight: 400;
        }

        .sidebar-menu.premium-sidebar .header {
            background: transparent !important;
            color: #6c7b88 !important;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 20px 20px 10px 20px !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 5px;
            margin-top: 10px;
        }

        /* Special style for the first header (Company Name) */
        .sidebar-menu.premium-sidebar .header.company-header {
            color: #f39c12 !important;
            /* Premium Orange */
            font-size: 12px;
            border-bottom: 2px solid rgba(243, 156, 18, 0.2);
            padding-bottom: 15px !important;
        }

        .sidebar-menu.premium-sidebar>li>a {
            border-left: 3px solid transparent;
            padding: 12px 20px;
            color: #aeb9bf;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .sidebar-menu.premium-sidebar>li:hover>a,
        .sidebar-menu.premium-sidebar>li.active>a {
            background: #2b2b40 !important;
            /* Lighter navy for active state */
            color: #ffffff !important;
            border-left-color: #f39c12;
            box-shadow: inset 5px 0 0 -2px rgba(243, 156, 18, 0.5);
        }

        .sidebar-menu.premium-sidebar .treeview-menu {
            background: #151521 !important;
            /* Darker navy for submenu */
            padding-left: 0;
        }

        .sidebar-menu.premium-sidebar .treeview-menu>li>a {
            padding: 10px 20px 10px 35px;
            color: #8aa4af;
            font-size: 0.9em;
            transition: color 0.2s;
        }

        .sidebar-menu.premium-sidebar .treeview-menu>li>a:hover {
            color: #ffffff;
            padding-left: 40px;
        }

        .sidebar-menu.premium-sidebar .treeview-menu>li>a>i {
            font-size: 0.8em;
            margin-right: 5px;
            opacity: 0.7;
        }

        /* Icon Styling */
        .sidebar-menu.premium-sidebar i.menu-icon {
            width: 25px;
            text-align: center;
            margin-right: 5px;
            font-size: 1.1em;
            transition: transform 0.2s ease;
            display: inline-block;
        }

        .sidebar-menu.premium-sidebar>li:hover i.menu-icon {
            transform: scale(1.15);
        }

        .text-premium-yellow {
            color: #f1c40f !important;
            text-shadow: 0 0 10px rgba(241, 196, 15, 0.3);
        }

        .text-premium-orange {
            color: #e67e22 !important;
            text-shadow: 0 0 10px rgba(230, 126, 34, 0.3);
        }
    </style>

    <ul class="sidebar-menu premium-sidebar" data-widget="tree">
        <li class="header company-header">
            <i class="fa fa-building-o" style="margin-right: 5px;"></i> <?php echo $sucursal->nombre; ?>
        </li>

        <!-- Ventas -->
        <li class="header">MÓDULO COMERCIAL</li>

        <?php include __DIR__ . '/../components/menu-sections/clientes.php'; ?>
        <?php include __DIR__ . '/../components/menu-sections/ventas.php'; ?>
        <?php include __DIR__ . '/../components/menu-sections/remision.php'; ?>
        <?php include __DIR__ . '/../components/menu-sections/nota-credito.php'; ?>

        <?php if ($u->opciones == 1): ?>
            <?php include __DIR__ . '/../components/menu-sections/cobranza.php'; ?>
        <?php endif; ?>

        <!-- Mantenimiento -->
        <li class="header">ADMINISTRACIÓN & CONFIG</li>

        <?php include __DIR__ . '/../components/menu-sections/productos.php'; ?>
        <?php include __DIR__ . '/../components/menu-sections/inventario.php'; ?>
        <?php include __DIR__ . '/../components/menu-sections/configuraciones.php'; ?>

        <!-- Caja -->
        <li class="header">FINANZAS</li>
        <?php include __DIR__ . '/../components/menu-sections/caja.php'; ?>

        <!-- Reportes -->
        <li class="header">BI & REPORTES</li>
        <?php include __DIR__ . '/../components/menu-sections/reportes.php'; ?>
    </ul>
    <?php
}

/**
 * Obtiene las sucursales del usuario
 * @param object $u Usuario actual
 * @return array Lista de sucursales
 */
function getUserSucursales($u)
{
    $usuarioss = UserData::getById($u->id_usuario);
    return SucursalUusarioData::verusucursalusuarios($usuarioss->id_usuario);
}

