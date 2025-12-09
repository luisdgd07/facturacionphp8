<?php
/**
 * Menu Section: Nota de Crédito
 */
?>
<li class="treeview">
    <a href="#">
        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span>NOTA DE CREDITO</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="index.php?view=nota_de_credito&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i> Notas de Credito</a></li>
        <li><a href="index.php?view=envionotacredito&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-cart-plus" style="color: orange;"></i> Envios a SIFEN</a></li>
    </ul>
</li>