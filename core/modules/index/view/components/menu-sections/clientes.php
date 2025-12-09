<?php
/**
 * Menu Section: Clientes
 */
?>
<li class="treeview">
    <a href="#">
        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span> CLIENTES</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="index.php?view=cliente&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-user"
                    style="color: orange;"></i> Clientes</a></li>
        <li><a href="index.php?view=estadodecuenta&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-money" style="color: orange;"></i>Estado de cuenta general</a></li>
        <li><a href="index.php?view=libroestado&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-money" style="color: orange;"></i>Estado de cuenta detallado</a></li>
        <li><a href="index.php?view=nuevocontrato&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-money" style="color: orange;"></i>Nuevo Contrato</a></li>
        <li><a href="index.php?view=contratos&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-money"
                    style="color: orange;"></i>Contratos</a></li>
        <li><a href="index.php?view=listadocontratoscliente2&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-money" style="color: orange;"></i>listado conceptos por Contratos</a></li>
        <li><a href="index.php?view=listadocontratoscliente&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-money" style="color: orange;"></i>Listado conceptos por clientes</a></li>
    </ul>
</li>