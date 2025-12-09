<?php
/**
 * Admin Menu Component
 * Menú lateral para usuarios administradores
 */
?>
<ul class="sidebar-menu" data-widget="tree">
    <li class="treeview">
        <a href="#">
            <i class="fa fa-building-o" style="color: yellow;"></i> <span> EMPRESA</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="index.php?view=sucursal"><i class="fa fa-cogs" style="color: orange;"></i> Nuevo</a></li>
        </ul>
    </li>

    <li class="header"><i class="fa fa-windows" style="color: orange;"></i> USUARIOS - CAJA</li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-user-secret" style="color: yellow;"></i> <span> USUARIOS</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="index.php?view=administrador"><i class="fa fa-user-secret" style="color: orange;"></i>
                    Usuarios</a></li>
        </ul>
    </li>

    <li class="header"><i class="fa fa-image" style="color: orange;"></i> REPORTE EN GENERAL</li>
    <li class="treeview">
        <a href="#">
            <i class="fa  fa-line-chart" style="color: yellow;"></i> <span> REPORTES</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="index.php?view=reporte_venta_general"><i class="fa fa-bar-chart-o" style="color: orange;"></i>
                    Reporte Ventas por Empresa</a></li>
        </ul>
    </li>

    <li class="header"><i class="fa fa-windows" style="color: orange;"></i> MENU NAVEGACIONAL</li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-gears" style="color: yellow;"></i> <span>CONFIGURACIÓN</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="index.php?view=config"><i class="fa fa-gear" style="color: orange;"></i> Configuración</a></li>
        </ul>
    </li>
</ul>