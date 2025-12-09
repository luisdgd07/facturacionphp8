 <?php if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"]!=""):?>
            <?php 
            $u=null;
            if($_SESSION["admin_id"]!=""){
          $u = UserData::getById($_SESSION["admin_id"]);
          // $user = $u->nombre." ".$u->apellido;
          }?>
 <?php
$cliente = AgenteData::VerId($_GET["id_agente"]);



// $url = "storage/plato/".$cliente->id_plato."/".$cliente->imagen;
?>
 <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-steam' style="color: orange;"></i>
        ACTUALIZAR REGISTRO DE AGENTE: <b style="color: orange;"><?php echo $cliente->nombre_agente; ?></b>
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
                      <form class="form-horizontal" action="index.php?action=actualizaragente" role="form" method="post" enctype="multipart/form-data">
                        <!-- <form class="form-horizontal" action="index.php?action=actualizarcategoria1" role="form" method="post" enctype="multipart/form-data"> -->
                
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Nombre Agente</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" value="<?php echo $cliente->nombre_agente?>" id="nombre_agente" name="nombre_agente"  maxlength="100">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Direccion:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" value="<?php echo $cliente->direccion ?>" id="direccion" name="direccion"  maxlength="500">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Telefono:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" value="<?php echo $cliente->telefono ?>" id="telefono" name="telefono"  maxlength="500">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Ruc:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="<?php echo $cliente->ruc ?>" id="ruc" name="ruc"   maxlength="500">
                    </div>
                   
                </div>
				
				    <div class="form-group has-warning">
				
				 <label for="inputEmail1" class="col-sm-3 control-label">Estado:</label>
          <div class="col-sm-9">
                      <select class="form-control" id="estado" name="estado">
                        <option value="<?php echo $cliente->estado ?>"><?php  if ($cliente->estado=="1"): echo "Activo"; else: echo "Inactivo"; endif ?></option>
                      
                            <option value="1">Activo</option>
                   
                       
                            <option value="2" >Inactivo</option>
                     
                    
                      </select>
                   </div>
				  </div>
              
            </div>
            <div class="modal-footer">
                <input type="hidden" name="sucursal_id" value="<?php echo $cliente->id_sucursal; ?>">
              <input type="hidden" name="id_agente" value="<?php echo $cliente->id_agente;?>">
         
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