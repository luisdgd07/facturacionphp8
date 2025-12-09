<div class="content-wrapper">
    <section class="content-header">
      <h1> <i class="fa fa-cubes"></i> 
        CAJA PRODUCTOS <small>Cierre de  Caja #<?php echo $_GET["id_venta"]; ?></small>
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <!-- <div class="box-tools pull-left">
            <a href="index.php?view=caja" data-toggle="modal" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></a>
          </div> -->
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <?php
			$products = VentaData::mostrar_caja($_GET["id_venta"]);
			if(count($products)>0){
			$total_total = 0;
			?>
			<br>
			<table class="table table-bordered table-hover	">
				<thead>
					<th></th>
					<th>Total</th>
					<th>Fecha</th>
				</thead>
				<?php foreach($products as $sell):?>

				<tr>
					<td style="width:30px;">
			<a href="./index.php?view=detalleventaproducto&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-default btn-xs"><i class="fa fa-arrow-right"></i></a>			


			<?php
			$operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
			?>
			</td>
					<td>

			<?php
			$total=0;
				foreach($operations as $operation){
					$product  = $operation->getProducto();
					$plato  = $operation->getVenta();
                    $total += (($operation->q*$product->precio_venta)-$plato->descuento);
					// $total += $operation->q*$product->precio_venta;
				}
					$total_total += $total;
					echo "<b>Bs ".number_format($total,0,".",".")."</b>";

			?>			

					</td>
					<td><?php echo $sell->fecha; ?></td>
				</tr>

			<?php endforeach; ?>

			</table>
			<h1>Total: <?php echo "Bs ".number_format($total_total,0,".","."); ?></h1>
				<?php
			}else {

			?>
				<div class="jumbotron">
					<h2>No hay ventas</h2>
					<p>No se ha realizado ninguna venta.</p>
				</div>

			<?php } ?>
        </div>
      </div>
    </section>
  </div>