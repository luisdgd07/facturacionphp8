<?php
/**
 * Menu Section: Configuraciones
 */
?>
<li class="treeview">
    <a href="#">
        <i class="fa fa-building-o" style="color: yellow;"></i> <span> CONFIGURACIONES</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="index.php?view=moneda&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-cogs"
                    style="color: orange;"></i> Moneda</a></li>
        <li><a href="index.php?view=cotizacion&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-cogs"
                    style="color: orange;"></i> Cotización</a></li>
        <li><a href="index.php?view=cofigfactura&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cogs" style="color: orange;"></i> Config. Factura</a></li>
        <li><a href="index.php?view=configmasiva&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cogs" style="color: orange;"></i> Config. Masiva</a></li>
        <li><a href="index.php?view=tipo_producto&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cogs" style="color: orange;"></i>Tipo Producto</a></li>
        <li><a href="index.php?view=deposito&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-cogs"
                    style="color: orange;"></i>Depósito</a></li>
        <li><a href="index.php?view=lista_precio&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cogs" style="color: orange;"></i>Lista de Precios</a></li>
        <li><a href="index.php?view=producto_precio&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cogs" style="color: orange;"></i>Precio de Productos</a></li>
        <li><a href="index.php?view=choferes&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-cogs"
                    style="color: orange;"></i>Choferes</a></li>
        <li><a href="index.php?view=vended&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-cogs"
                    style="color: orange;"></i>Vendedor</a></li>
        <li><a href="index.php?view=vehiculos&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-cogs"
                    style="color: orange;"></i>Vehiculos</a></li>
        <li><a href="index.php?view=placa_fabrica&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa  fa-steam" style="color: orange;"></i> Placas</a></li>
    </ul>
</li>