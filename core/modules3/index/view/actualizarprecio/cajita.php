 <?php if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"]!=""):?>
            <?php 
            $u=null;
            if($_SESSION["admin_id"]!=""){
          $u = UserData::getById($_SESSION["admin_id"]);
          // $user = $u->nombre." ".$u->apellido;
          }?>
 <?php
   $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
 
$cliente = ProductoData::getByIlistadoproducto($_GET["id_precio"],$_GET["id_producto"]);
// $url = "storage/plato/".$cliente->id_plato."/".$cliente->imagen;
?>
 <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-steam' style="color: orange;"></i>
        ACTUALIZAR PRECIO PRODUCTO: <b style="color: orange;"><?php echo $cliente->nombre_product ?></b>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-body">
              <div class="box box-warning">
                    <div class="panel-body">
                      <form class="form-horizontal" action="index.php?action=actualizarpercioproducto" role="form" method="post" enctype="multipart/form-data">
               
               
				
				
				
				
				 
				 <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Importe:</label>
                    
					  <div class="col-lg-4">
                            <input type="text" name="importe_precio" class="form-control" id="importe_precio" onkeypress="return solonumeross(event);" placeholder="Precio de producto" maxlength="800" required="" >
                            <span class="fa fa-laptop form-control-feedback"></span>
                          </div>
					  
					  
					  <span class="fa fa-file-text form-control-feedback"></span>
                   
                </div>
				
				
			
				
				
				
            </div>
            <div class="modal-footer">
			 <input type="hidden" name="id_precio" value="<?php echo $_GET["id_precio"];?>">
			  <input type="hidden" name="id_producto" value="<?php echo $_GET["id_producto"];?>">
              <input type="hidden" name="id_deposito" value="<?php echo $_GET["id_deposito"];?>">
              <input type="hidden" name="id_sucursal" value="<?php echo $_GET["id_sucursal"];?>">
              <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
              </form>
                    </div>
                  </div>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
  <?php else:?>
   <?php endif;?>