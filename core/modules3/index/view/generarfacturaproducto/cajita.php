<body class="hold-transition skin-blue sidebar-mini" onload="window.print();">
	<?php if(isset($_GET["id_venta"]) && $_GET["id_venta"]!=""):?>
                <?php
                $sell = VentaData::getById($_GET["id_venta"]);
                $operations = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
                $total = 0;
                ?>
                <?php
                if(isset($_COOKIE["selled"])){
                  foreach ($operations as $operation) {
                //    print_r($operation);
                    $qx = OperationData::getQYesFf($operation->producto_id);
                    // print "qx=$qx";
                      $p = $operation->getProducto();
                    if($qx==0){
                           
                    }else if($qx<=$p->minimo_inventario/2){
                     
                    }else if($qx<=$p->minimo_inventario){
                     
                    }
                  }
                  setcookie("selled","",time()-18600);
                }

                ?>
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-users'></i>
        DETALLE DE LA VENTA
       <!-- <marquee> Lista de Medicamentos</marquee> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="./"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li>Empleado</li>
        <li class="active">Lista de Empleados</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    	<div class="row">
    		<div class="col-xs-8">
    			<!-- <table class="table"> -->
	                <!-- <tr> -->
	                  <td>
	                  	<div class="row">
	                  		<div class="col-xs-3">
				    			<img src="storage/iconos/logo.png" alt="" >
				    		</div>
				    		<div class="col-xs-7">
                  <br>
                  <br>
                  <h1 class=" pull-right"><b>FACTURA</b></h1>
				    		</div>
                <div class="col-xs-2">
                  
                </div>
	                  	</div>
	                  </td>
	                <!-- </tr> -->
                <!-- </table> -->
    		</div>
    		<div class="col-xs-4">
    			<table class="table table-bordered alert alert-warning" >
	                <tr>
	                  <td>
	                  	<center><b>NIT 9999999990</b></center>
								<center><h6>FACTURA N. 100052</h6></center>
								<center><h6>AUTORIZACION N. 9999999999</h6></center>
								<!-- <center><h5><b>Factura</b></h5></center> -->
								<!-- <h6>Nª. <?php echo $_GET["id_venta"]; ?></h6> -->
	                  </td>
	                </tr>
                </table>
                <!-- <p class=" pull-right"><b>ORIGINAL</b></p> -->
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-xs-8">
    			<!-- <table class="table"> -->
	                <!-- <tr> -->
	                  <td>
	                  	<div class="row">
	                  		<div class="col-xs-6">
                          <h6>Empresa Comercial de Equipos <br>Electronicos <br>
                          7mo Anillo Santos Dumot C<br>
                        Tobochi N. 3</h6>
				    		</div>
				    		<div class="col-xs-6">
								<!-- <b>Forma de Pago:</b><br>
								<b>Ruc:</b><br>
								<b>Telefono:</b> -->
				    		</div>
	                  	</div>
	                  </td>
	                <!-- </tr>
                </table> -->
    		</div>
    	</div>
      <div class="row">
        <div class="col-xs-12">
          <!-- <table class="table"> -->
                  <!-- <tr> -->
                    <td>
                      <div class="row">
                        <div class="col-xs-8">
                          <h4>Santa Cruz, <?php echo $sell->fecha; ?></h4>
                          <h4><b>Señor(res):</b> <?php echo $sell->getCliente()->nombre." ".$sell->getCliente()->apellido;?></h4>
                        </div>
                        <div class="col-xs-4">
                        <h4> <br> </h4>
                        <h4 class="right"><b>NIT / CI: </b> <?php echo $sell->getCliente()->dni;?></h4>
                        </div>
                      </div>
                    </td>
                  <!-- </tr>
                </table> -->
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- <div class="box-body"> -->
				<table class="table table-bordered table-hover">
                <thead>
                  <th>CODIGO</th>
                  <th>CANTIDAD</th>
                  <th><center>Concepto</center></th>
                  <th>P. UNIT.</th>
                  <th>TOTAL</th>

                </thead>
              <?php
                foreach($operations as $operation){
                  $product  = $operation->getProducto();
              ?>
              <tr>
                <td width="30px"><?php echo $product->id_producto ;?></td>
                <td width="40px"><?php echo $operation->q ;?></td>
                <td><?php echo $product->nombre ;?></td>
                <td width="80px">Bs <?php echo number_format($product->precio_venta,2,".",",") ;?></td>
                <td width="80px"><b>Bs <?php echo number_format($operation->q*$product->precio_venta,2,".",",");$total+=$operation->q*$product->precio_venta;?></b></td>
              </tr>
              <?php
                }
                ?>
              </table>
              <br>
              <div class="row">
              	<div class="col-xs-12">
              		<table class="table">
	                <tr>
	                  <td><b>SON:</b> monto en letras 00/100 Bs</td>
                    <td width="70px"> <b>Total Bs</b></td>
	                  <td class="table-bordered" ><?php echo number_format($total-  $sell->descuento,2,'.',','); ?></td>
	                </tr>
	               <!--  <tr>
	                  <td>SUBTOTAL</td>
	                  <td width="80px">Gs/. <?php echo number_format($total,2,'.',','); ?></td>
	                </tr> -->
	                <tr>
	                  <td><B>CODIGO DE CONTROL:</B> C6-54-9D-CF-F1</td>
                    <td > </td>
	                  <td width="270px"><b>FECHA LIMITE DE EMISION:</b> 12/12/2020</td>
	                </tr>
	                </table><h6>La reproduccion total o parcial y el uso no autorizado es esta nota fiscal, constituye un delito a ser sancionado conforme a ley.</h6>
	    		</div>
          <!-- <p>La reproduccion total o parcial y el uso no autorizado es esta nota fiscal, constituye un delito a ser sancionado conforme a ley.</p> -->
          
              </div>
                <?php else:?>
                  501 Internal Error
                <?php endif; ?>
            <!-- </div> -->
          </div>
        </div>
      </div>
    </section>   
  </div>
</body>