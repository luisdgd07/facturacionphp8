<?php
/**
 * Menu Section: Productos
 */
?>
<li class="treeview">
    <a href="#">
        <i class="fa fa-android" style="color: yellow;"></i> <span> PRODUCTOS</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="index.php?view=nuevoproducto1&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-laptop" style="color: orange;"></i>Nuevo producto</a></li>
        <li><a href="index.php?view=producto&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-laptop"
                    style="color: orange;"></i> Lista de Productos</a></li>
        <li><a href="index.php?view=categoria&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa  fa-steam"
                    style="color: orange;"></i> Categoria</a></li>
        <li><a href="index.php?view=marca&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa  fa-steam"
                    style="color: orange;"></i> Marca</a></li>
        <li><a href="index.php?view=grupos&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa  fa-steam"
                    style="color: orange;"></i> Grupos</a></li>
    </ul>
</li>