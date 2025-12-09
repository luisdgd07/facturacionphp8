 <?php if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"]!=""):?>
            <?php 
            $u=null;
            if($_SESSION["admin_id"]!=""){
          $u = UserData::getById($_SESSION["admin_id"]);
          // $user = $u->nombre." ".$u->apellido;
          }?>
 <?php
$cliente = MonedaData::VerId($_GET["id_tipomoneda"]);
// $url = "storage/plato/".$cliente->id_plato."/".$cliente->imagen;
?>
 <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-money' style="color: orange;"></i>
        Actualizando Datos de la Moneda <b style="color: orange;"><?php echo $cliente->nombre; ?></b>
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
                      <form class="form-horizontal" action="index.php?action=actualizarmoneda" role="form" method="post" enctype="multipart/form-data">
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nombre" name="nombre" required onkeypress="return sololetras(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="80" value="<?php echo $cliente->nombre ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Valor</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="valor" name="valor" required value="<?php echo $cliente->valor ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Simbolo</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="simbolo">
                        <option value="<?php echo $cliente->simbolo ?>"><?php echo $cliente->simbolo ?></option>
                        <option value="US$">USD - Dolar</option>
                        <option value="₲">GS - Guaraníes</option>
                        <!-- <option value="₲">PYG</option> -->
                        <option value="R$">BRL - Real brasileño</option>
                      </select> 
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Descripcion</label>

                    <div class="col-sm-9">
                      <textarea class="form-control" id="descripcion" name="descripcion"><?php echo $cliente->descripcion ?></textarea><span class="fa fa-list form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="id_tipomoneda" value="<?php echo $_GET["id_tipomoneda"];?>">
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