<?php
/**
 * Menu Section: Inventario
 */
?>
<li class="treeview">
    <a href="#">
        <i class="fa fa-building-o" style="color: yellow;"></i> <span> INVENTARIO</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="index.php?view=inventario&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa  fa-heartbeat" style="color: orange;"></i>Stock de Productos</a></li>
        <li><a href="index.php?view=transacciones&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cogs" style="color: orange;"></i> Movimiento de Stock</a></li>
        <li><a href="index.php?view=transa&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-cogs"
                    style="color: orange;"></i> Transacciones</a></li>
        <li><a href="index.php?view=transacioness&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cogs" style="color: orange;"></i> Transacciones por producto</a></li>
    </ul>
</li>