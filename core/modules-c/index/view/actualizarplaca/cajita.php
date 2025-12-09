 <?php if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"]!=""):?>
            <?php 
            $u=null;
            if($_SESSION["admin_id"]!=""){
          $u = UserData::getById($_SESSION["admin_id"]);
          // $user = $u->nombre." ".$u->apellido;
          }?>
 <?php
$cliente = PlacaData::VerId($_GET["id_placa"]);



// $url = "storage/plato/".$cliente->id_plato."/".$cliente->imagen;
?>
 <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-steam' style="color: orange;"></i>
        ACTUALIZACIÓN DE REGISTRO DE PLACAS: <b style="color: orange;"><?php echo $cliente->registro; ?></b>
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
                      <form class="form-horizontal" action="index.php?action=actualizarplaca_fabrica" role="form" method="post" enctype="multipart/form-data">
                        <!-- <form class="form-horizontal" action="index.php?action=actualizarcategoria1" role="form" method="post" enctype="multipart/form-data"> -->
                
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Serie</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" value="<?php echo $cliente->registro?>" id="registro" name="registro" required  onpaste="return false" maxlength="10">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">N° placa inicio</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" value="<?php echo $cliente->placa_inicio ?>" id="placa_inicio" name="placa_inicio" required onkeypress="return solonumeross(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">N° Placa fin:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" value="<?php echo $cliente->placa_fin ?>" id="placa_fin" name="placa_fin" required onkeypress="return solonumeross(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Total placas:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="<?php echo $cliente->total_placas ?>" id="total_placas" name="total_placas"  onkeypress="return solonumeross(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500">
                    </div>
                    <label for="inputEmail1" class="col-sm-2 control-label">Diferencia:</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" value="<?php echo $cliente->diferencia ?>" id="diferencia" name="diferencia"  onkeypress="return solonumeross(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500" >
                    </div>
                </div>
				
				    <div class="form-group has-warning">
				
				 <label for="inputEmail1" class="col-sm-3 control-label">Estado:</label>
          <div class="col-sm-9">
                      <select class="form-control" id="estado_placa" name="estado_placa">
                        <option value="<?php echo $cliente->estado_placa ?>"><?php  if ($cliente->estado_placa=="1"): echo "Activo"; else: echo "Inactivo"; endif ?></option>
                      
                            <option value="1">Activo</option>
                   
                       
                            <option value="2" >Inactivo</option>
                     
                    
                      </select>
                   </div>
				  </div>
              
            </div>
            <div class="modal-footer">
              <input type="hidden" name="sucursal_id" value="<?php echo $cliente->id_sucursal; ?>">
              <input type="hidden" name="id_placa" value="<?php echo $cliente->id_placa; ?>">
              <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $cliente->sucursal_id; ?>">
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