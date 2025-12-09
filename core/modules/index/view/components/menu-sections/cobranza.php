<?php
/**
 * Menu Section: Cobranza
 */
?>
<li class="header"><i class="fa fa-windows" style="color: orange;"></i> COBRANZA CLIENTES</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span> COBRANZA</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="index.php?view=cobranza1&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-money"
                    style="color: orange;"></i>Cobranza</a></li>
        <li><a href="index.php?view=cobros_realizados&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i>listado de Cobranzas</a></li>
        <li><a href="index.php?view=listaretenciones&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i>listado de Retenciones</a></li>
    </ul>
</li>