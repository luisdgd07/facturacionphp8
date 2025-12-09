 <?php if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"]!=""):?>
            <?php 
            $u=null;
            if($_SESSION["admin_id"]!=""){
          $u = UserData::getById($_SESSION["admin_id"]);
          // $user = $u->nombre." ".$u->apellido;
          }?>
 <?php
$cliente = ProductoData::getByIddeposito($_GET["id_deposito"]);
// $url = "storage/plato/".$cliente->id_plato."/".$cliente->imagen;
?>
 <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-steam' style="color: orange;"></i>
        ACTUALIZAR DEPOSITO: <b style="color: orange;"><?php echo $cliente->NOMBRE_DEPOSITO; ?></b>
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
                      <form class="form-horizontal" action="index.php?action=actualizardeposito" role="form" method="post" enctype="multipart/form-data">
               
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Descripción</label>

                    <div class="col-sm-9">
                      <textarea class="form-control" id="descripcion" name="descripcion"><?php echo $cliente->NOMBRE_DEPOSITO ?></textarea><span class="fa fa-list form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
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