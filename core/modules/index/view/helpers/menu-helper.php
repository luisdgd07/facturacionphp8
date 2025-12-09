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
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header"
            style="font-size: 15px; margin: auto; text-align: center; color: #FFA200; border: 7px solid #FF0000;">
            <i></i><?php echo $sucursal->nombre; ?>
        </li>

        <!-- Remisiones -->
        <li class="active">
            <a href="index.php?view=remision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>">
                <i class="fa fa-money" style="color: yellow;"></i> <span>REALIZAR REMISION</span>
                <span class="pull-right-container">
                    <small class="label pull-right bg-yellow">REMISION</small>
                </span>
            </a>
        </li>

        <li class="active">
            <a href="index.php?view=remision1&id_sucursal=<?php echo $sucursal->id_sucursal; ?>">
                <i class="fa fa-laptop" style="color: yellow;"></i> <span>REMISIONES PENDIENTES</span>
                <span class="pull-right-container">
                    <small class="label pull-right bg-yellow">PENDIENTES</small>
                </span>
            </a>
        </li>

        <li class="active">
            <a href="index.php?view=envioventaremision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>">
                <i class="fa fa-laptop" style="color: yellow;"></i> <span>ENVIAR VENTA C/ REMISION</span>
                <span class="pull-right-container">
                    <small class="label pull-right bg-yellow">ENVIAR VENTA C/ REMISION</small>
                </span>
            </a>
        </li>

        <!-- Ventas -->
        <li class="header"><i class="fa fa-windows" style="color: orange;"></i> VENTAS</li>

        <?php include __DIR__ . '/menu-sections/clientes.php'; ?>
        <?php include __DIR__ . '/menu-sections/remision.php'; ?>
        <?php include __DIR__ . '/menu-sections/ventas.php'; ?>
        <?php include __DIR__ . '/menu-sections/nota-credito.php'; ?>

        <?php if ($u->opciones == 1): ?>
            <?php include __DIR__ . '/menu-sections/cobranza.php'; ?>
        <?php endif; ?>

        <!-- Mantenimiento -->
        <li class="header"><i class="fa fa-windows" style="color: orange;"></i> MANTENIMIENTO</li>

        <?php include __DIR__ . '/menu-sections/productos.php'; ?>
        <?php include __DIR__ . '/menu-sections/inventario.php'; ?>
        <?php include __DIR__ . '/menu-sections/configuraciones.php'; ?>

        <!-- Caja -->
        <li class="header"><i class="fa fa-windows" style="color: orange;"></i> CAJA</li>
        <?php include __DIR__ . '/menu-sections/caja.php'; ?>

        <!-- Reportes -->
        <li class="header"><i class="fa fa-image" style="color: orange;"></i> REPORTE EN GENERAL</li>
        <?php include __DIR__ . '/menu-sections/reportes.php'; ?>
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
