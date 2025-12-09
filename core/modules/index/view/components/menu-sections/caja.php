<?php
/**
 * Menu Section: Caja
 */
?>
<li class="treeview">
    <a href="#">
        <i class="fa fa-cube" style="color: yellow;"></i> <span> CAJA</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a
                href="index.php?view=cajausuario&id_sucursal=<?php echo $sucursal->id_sucursal; ?>&id_usuario=<?php echo $u->id_usuario; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i>Iniciar Caja</a></li>
    </ul>
</li>