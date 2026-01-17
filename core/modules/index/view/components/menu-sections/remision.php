<?php
/**
 * Menu Section: Remision
 */
?>
<li class="treeview">
    <a href="#">
        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span> REMISION</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="index.php?view=remision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-money"
                    style="color: orange;"></i> Realizar Remisión</a></li>
        <li><a href="index.php?view=remision1&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-money"
                    style="color: orange;"></i> Rem. pendientes locales</a></li>
        <li><a href="index.php?view=remisionexport&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-money" style="color: orange;"></i> Rem. pendientes a Exportar</a></li>
        <li><a href="index.php?view=listadoplacas&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i> Listado de Placas</a></li>
        <li><a href="index.php?view=remision2&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-money"
                    style="color: orange;"></i> Remisiones </a></li>
        <li><a href="index.php?view=envioremision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-money" style="color: orange;"></i> Envio de Remisión </a></li>
        <li><a href="index.php?view=envioventaremision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-money" style="color: orange;"></i> Envio de Venta c/ Remisión </a></li>
    </ul>
</li>