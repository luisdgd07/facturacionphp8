<?php
/**
 * Menu Section: Reportes
 */
?>
<li class="treeview">
    <a href="#">
        <i class="fa  fa-line-chart" style="color: yellow;"></i> <span> REPORTES</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="index.php?view=libroop&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte entradas y salidas </a></li>
        <li><a href="index.php?view=libroventag&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte Ventas Electronicas</a></li>

        <?php if ($u->opciones == 1): ?>
            <li><a href="index.php?view=libroestadocobros&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                        class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte Cobranzas </a></li>
        <?php endif; ?>

        <li><a href="index.php?view=reportestockproductos&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte Stock de Productos</a></li>
        <li><a href="index.php?view=reporteresolucion&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                    class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte Resolución 90</a></li>

        <li>
            <?php if ($sucursal->tipo_recibo == 0): ?>
                <a target="_BLANK" href="http://192.168.30.154:84/importacion_mercury/"><i class="fa fa-bar-chart-o"
                        style="color: orange;"></i>Exportar Ventas Electrónicas</a>
            <?php elseif ($sucursal->tipo_recibo == 1): ?>
                <a target="_BLANK" href="http://192.168.30.154:84/importacion_bravo/"><i class="fa fa-bar-chart-o"
                        style="color: orange;"></i>Exportar Ventas Electrónicas</a>
            <?php endif; ?>
        </li>
    </ul>
</li>