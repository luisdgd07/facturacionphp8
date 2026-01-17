<?php
/**
 * Menu Section: Ventas
 */
?>
<li class="treeview">
    <a href="#">
        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span> VENTAS</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="index.php?view=vender&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-money"
                    style="color: orange;"></i> Realizar Venta</a></li>
        <li><a href="index.php?view=ventas&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-cart-plus"
                    style="color: orange;"></i> Ventas</a></li>
        <li><a href="index.php?view=vender2&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-money"
                    style="color: orange;"></i> Realizar Venta Contrato</a></li>
        <li><a href="index.php?view=masiva&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-cart-plus"
                    style="color: orange;"></i> Ventas Masivas</a></li>
        <li><a href="index.php?view=ventas-masiva-detalle&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i> Detalles Ventas Masivas</a></li>
        <li><a href="index.php?view=envioporlote&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i> Envios a SIFEN</a></li>
        <li><a href="index.php?view=cobrocaja&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i> Cobro Caja</a></li>
        <li><a href="index.php?view=cobros&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-cart-plus"
                    style="color: orange;"></i> Cobros</a></li>
        <li><a href="index.php?view=listacredito&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i> Credito Clientes</a></li>
        <li><a href="index.php?view=tarjeta&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i>Tarjeta</a></li>
        <li><a href="index.php?view=retencion&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i>Retención</a></li>
        <li><a href="index.php?view=cuentabancaria&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i> Movimiento Bancario </a></li>

    </ul>
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span>VENTA DE EXPORTACIÓN</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="index.php?view=venderproforma&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i>Realizar Proforma</a></li>
        <li><a href="index.php?view=venderexport&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i>Realizar Exportación</a></li>

        <li><a href="index.php?view=ventasproforma&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i>Listado de Proformas</a></li>
        <li><a href="index.php?view=ventasexportacion&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i>Listado de Exportaciones</a></li>
        <li><a href="index.php?view=envioexportacion&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i>Enviar a Sifen.</a></li>

    </ul>
</li>