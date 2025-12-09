  <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
  <!-- Content Wrapper. Contains page content -->
  <?php if($u->is_admin):?>
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
      <h1><i class='fa fa-list' style="color: orange;"></i>
        VISTA PREVIA DE DISEÑO DEL RECIBO
       <!-- <marquee> Lista de Medicamentos</marquee> -->
      </h1>
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
                          <h1><br> </h1>

                          <h4 style="color: orange;"><b>ONLIBO RECIBO</b></h4>
                        </div>
	                  		<div class="col-xs-3">
				    			<img src="storage/iconos/logo.png" alt="" width="80px" style="background-size: 20%;" >
				    		</div>
				    		<div class="col-xs-6">
                  <br>
                  <br>
                  <!-- <h1 class=" pull-right"><b>FACTURA</b></h1> -->
				    		</div>
                <!-- <div class="col-xs-2">
                  
                </div> -->
	                  	</div>
	                  </td>
	                <!-- </tr> -->
                <!-- </table> -->
    		</div>
    		<div class="col-xs-4">
    			<table class="table " >
	                <tr>
	                  <td>
                      <h4><br></h4>
	                  	<center><b>Bs.................<?php echo $sell->total- $sell->descuento; ?>........................</b></center>
                      <center><b>USD.........................................</b></center>
	                  </td>
	                </tr>
                </table>
                <!-- <p class=" pull-right"><b>ORIGINAL</b></p> -->
    		</div>
    	</div>
    	<div class="row">

    	</div>
      <div class="row">
        <div class="col-xs-12">
          <!-- <table class="table"> -->
                  <!-- <tr> -->
                    <td>
                      <div class="row">
                        <div class="col-xs-8">
                          <h4><b>He recibido de:</b>................<?php echo $sell->getCliente()->nombre." ".$sell->getCliente()->apellido; ?>...........................................................................
                          <br><br><h4><b>La suma de:</b>...........<?php echo $sell->total- $sell->descuento; ?>................................................................................ <b>Bolivarianos/Dolares</b></h4>
                          <br><h4><b>Por concepto de:</b>.........Compra..................................................................................</h4>
                          <br><center><h4><b>A cuenta:</b>..........  <b>Saldo:</b>.......... <b>Total:</b>....<?php echo $sell->total- $sell->descuento; ?>......</h4></center>
                          <br><h4><b>Bolivia:</b> <?php echo $sell->fecha; ?></h4>
                          <br><br><br><div class="col-xs-4">
                            <h4>
                              <p><center>
                                <img src="storage/iconos/trabajo.png" alt="" width="40px">
                                ________________________
                                     Recibi Conforme
                              </center>
                              </p>
                            </h4>
                          </div>
                          <div class="col-xs-4">
                            <h4 class="height">
                              <p class="height">
                                <center>
                                  <img src="storage/iconos/trabajo.png" alt="" width="40px">
                                ________________________
                                     Entregue Conforme
                                </center>
                              </p>
                            </h4>
                          </div>
                        </div>
                        <div class="col-xs-4">
                          <form role="form" method="post" action="./?action=imagenrecibo"  enctype="multipart/form-data">
                        <div class="panel panel-warning text-center">
                          <?php $carpetas = VetaReciboData::getAllByTeamId($_GET["id_venta"]); ?>
                          <?php
                          if(count($carpetas)>0){
                            // si hay usuarios
                            ?>
                              <?php
                            foreach($carpetas as $ver){
                              $car = $ver->getRecibo();
                              $img = "storage/recio/".$car->imagen;
                                if($car->imagen==""){
                                  $img="storage/iconos/loginn.png";
                                }
                              ?>
                          <div class="panel-heading">
                                <a class="fancybox" href="<?php echo $img; ?>" target="_blank" data-fancybox-group="gallery" title="Imagen del recibo"><img class="fancyResponsive" src="<?php echo $img; ?>" alt="" width="90%" height="100%" /></a>
                          </div>
                          <?php
                                }
                          }
                          else{
                            echo "<p class='alert alert-danger'>Falta Cargar el Imagen</p>";
                          }
                          

                        ?>
                      </div>
                          <div class="form-group">
                            <div class="col-lg-12">
                              <input type="file" class="form-control" id="imagen" name="imagen">
                            </div>
                          </div>
                      <br>
                      <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-4">
                        <input type="hidden" name="id_venta" value="<?php echo $_GET["id_venta"];?>">
                        <input type="hidden" name="tid" value="<?php echo $_GET["tid"];?>">
                          <button type="submit" class="btn btn-warning" >Cargar Imagen</button>
                        </div>
                      </div>
                      
                    </form>
                        </div>
                      <!-- </div> -->
                    </td>

      <?php else:?>
                  501 Internal Error
                <?php endif; ?>
                <br>
                <br>
                <div class="row">
                  <div class="col-xs-12 pull-right">
                    <!-- <center> -->
                      <a href="index.php?view=generarrecibo&id_venta=<?php echo $_GET["id_venta"]?>" class="btn btn-primary btn-sm btn-flat pull-right" target="_blank"><i class='fa fa-print'></i> Imprimir</a>
                      <a href="recibo.php?id_venta=<?php echo $_GET["id_venta"];?>" class="btn btn-info btn-sm btn-flat pull-right"  target="_blank"><i class='fa fa-file-pdf-o'></i> Generar PDF</a>
                    <!-- </center> -->
                  </div>
                </div>
    </section>   
  </div>
  <?php endif ?>
  <?php if($u->is_empleado):?>
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
      <h1><i class='fa fa-list' style="color: orange;"></i>
        VISTA PREVIA DE DISEÑO DEL RECIBO
       <!-- <marquee> Lista de Medicamentos</marquee> -->
      </h1>
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
                          <h1><br> </h1>

                          <h4 style="color: orange;"><b>ONLIBO RECIBO</b></h4>
                        </div>
                        <div class="col-xs-3">
                  <img src="storage/iconos/logo.png" alt="" width="80px" style="background-size: 20%;" >
                </div>
                <div class="col-xs-6">
                  <br>
                  <br>
                  <!-- <h1 class=" pull-right"><b>FACTURA</b></h1> -->
                </div>
                <!-- <div class="col-xs-2">
                  
                </div> -->
                      </div>
                    </td>
                  <!-- </tr> -->
                <!-- </table> -->
        </div>
        <div class="col-xs-4">
          <table class="table " >
                  <tr>
                    <td>
                      <h4><br></h4>
                      <center><b>Bs.................<?php echo $sell->total- $sell->descuento; ?>........................</b></center>
                      <center><b>USD.........................................</b></center>
                    </td>
                  </tr>
                </table>
                <!-- <p class=" pull-right"><b>ORIGINAL</b></p> -->
        </div>
      </div>
      <div class="row">

      </div>
      <div class="row">
        <div class="col-xs-12">
          <!-- <table class="table"> -->
                  <!-- <tr> -->
                    <td>
                      <div class="row">
                        <div class="col-xs-8">
                          <h4><b>He recibido de:</b>................<?php echo $sell->getCliente()->nombre." ".$sell->getCliente()->apellido; ?>...........................................................................
                          <br><br><h4><b>La suma de:</b>...........<?php echo $sell->total- $sell->descuento; ?>................................................................................ <b>Bolivarianos/Dolares</b></h4>
                          <br><h4><b>Por concepto de:</b>.........Compra..................................................................................</h4>
                          <br><center><h4><b>A cuenta:</b>..........  <b>Saldo:</b>.......... <b>Total:</b>....<?php echo $sell->total- $sell->descuento; ?>......</h4></center>
                          <br><h4><b>Bolivia:</b> <?php echo $sell->fecha; ?></h4>
                          <br><br><br><div class="col-xs-4">
                            <h4>
                              <p><center>
                                <img src="storage/iconos/trabajo.png" alt="" width="40px">
                                ________________________
                                     Recibi Conforme
                              </center>
                              </p>
                            </h4>
                          </div>
                          <div class="col-xs-4">
                            <h4 class="height">
                              <p class="height">
                                <center>
                                  <img src="storage/iconos/trabajo.png" alt="" width="40px">
                                ________________________
                                     Entregue Conforme
                                </center>
                              </p>
                            </h4>
                          </div>
                        </div>
                        <div class="col-xs-4">
                          <form role="form" method="post" action="./?action=imagenrecibo"  enctype="multipart/form-data">
                        <div class="panel panel-warning text-center">
                          <?php $carpetas = VetaReciboData::getAllByTeamId($_GET["id_venta"]); ?>
                          <?php
                          if(count($carpetas)>0){
                            // si hay usuarios
                            ?>
                              <?php
                            foreach($carpetas as $ver){
                              $car = $ver->getRecibo();
                              $img = "storage/recio/".$car->imagen;
                                if($car->imagen==""){
                                  $img="storage/iconos/loginn.png";
                                }
                              ?>
                          <div class="panel-heading">
                                <a class="fancybox" href="<?php echo $img; ?>" target="_blank" data-fancybox-group="gallery" title="Imagen del recibo"><img class="fancyResponsive" src="<?php echo $img; ?>" alt="" width="90%" height="100%" /></a>
                          </div>
                          <?php
                                }
                          }
                          else{
                            echo "<p class='alert alert-danger'>Falta Cargar el Imagen</p>";
                          }
                          

                        ?>
                      </div>
                          <div class="form-group">
                            <div class="col-lg-12">
                              <input type="file" class="form-control" id="imagen" name="imagen">
                            </div>
                          </div>
                      <br>
                      <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-4">
                        <input type="hidden" name="id_venta" value="<?php echo $_GET["id_venta"];?>">
                        <input type="hidden" name="tid" value="<?php echo $_GET["tid"];?>">
                          <button type="submit" class="btn btn-warning" >Cargar Imagen</button>
                        </div>
                      </div>
                      
                    </form>
                        </div>
                      <!-- </div> -->
                    </td>

      <?php else:?>
                  501 Internal Error
                <?php endif; ?>
                <br>
                <br>
                <div class="row">
                  <div class="col-xs-12 pull-right">
                    <!-- <center> -->
                      <a href="index.php?view=generarrecibo1&id_venta=<?php echo $_GET["id_venta"]?>" class="btn btn-primary btn-sm btn-flat pull-right" target="_blank"><i class='fa fa-print'></i> Imprimir</a>
                      <a href="recibo1.php?id_venta=<?php echo $_GET["id_venta"];?>" class="btn btn-info btn-sm btn-flat pull-right"  target="_blank"><i class='fa fa-file-pdf-o'></i> Generar PDF</a>
                    <!-- </center> -->
                  </div>
                </div>
    </section>   
  </div>
  <?php endif ?>
<?php endif ?>