<?php
$configuracion = ConfigData::getById($_GET["id_empresa"]);
$url = "storage/sis/admin/$configuracion->logo";
$url = "storage/sis/admin/$configuracion->imagen";
if($configuracion!=null):
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1><li class="fa fa-refresh fa-spin fa-1x fa-left" style="color: orange;"></li>
      <?php
        $config = ConfigData::getAll();
          if(count($config)>0){
            ?>
            <?php
            foreach($config as $configuracion){ ?>
              Configuración de <b><?php echo $configuracion->nombre;?></b> 
            <?php
            }
          }else{}
      ?>
    </h1>
    <?php
             if(isset($_SESSION["actualizar_configuracion"])):?>
              <p class="alert alert-info"><i class="fa fa-check"></i> Atualización Existosa</p>
            <?php 
            unset($_SESSION["actualizar_configuracion"]);
            endif; ?>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-body">
            <div class="form-responsive">
              <marquee><h1 style="color: orange"><b><?php echo $configuracion->nombre; ?></b></h1></marquee>
              <hr>
              <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="index.php?action=configuracion">
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-3 control-label"></label>
                  <div class="col-md-3">
                    
                  </div>
                  <label for="inputEmail1" class="col-lg-1 control-label"></label>
                  <div class="col-md-3">
                    <?php if($configuracion->imagen!=""):?>
                    <br>
                    <img src="storage/sis/admin/<?php echo $configuracion->imagen;?>"class="img-circle" alt="User Image" style="width:80px;">
                    <?php endif;?>
                  </div>
                  <label for="inputEmail1" class="col-lg-1 control-label"></label>
                  <div class="col-md-2">
                    <?php if($configuracion->logo!=""):?>
                     <br>
                     <img src="storage/sis/admin/<?php echo $configuracion->logo;?>"class="img-circle" alt="User Image" style="width:80px;">
                     <?php endif;?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Logo:</label>
                  <div class="col-md-4">
                   <input type="file" name="logo" id="logo">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Nombre:</label>
                   <div class="col-md-4 form-group has-feedback">
                    <input type="text" name="nombre" class="form-control" id="nombre" value="<?php echo $configuracion->nombre; ?>" placeholder="Actualice el Nombre de la Pagina"  onkeypress="return sololetras(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="15">
                    <span class="fa fa-institution form-control-feedback"></span>
                   </div>
                   <label for="inputEmail1" class="col-lg-2 control-label">Dirección:</label>
                   <div class="col-md-4 form-group has-feedback">
                    <input type="text" name="direccion" class="form-control" id="direccion" value="<?php echo $configuracion->direccion; ?>" placeholder="Actualice l Dirección de la Pagina"  onkeypress="return sololetras(event)" onpaste="return false" maxlength="70">
                    <span class="fa fa-map-marker form-control-feedback"></span>
                   </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Telefono:</label>
                   <div class="col-md-4 form-group has-feedback">
                    <input type="text" name="telefono" class="form-control" id="telefono" value="<?php echo $configuracion->telefono; ?>" placeholder="Actualice el Numero de la Pagina"  onkeypress="return solonumeros(event);" pattern=".{9,99}" onpaste="return false" maxlength="12">
                    <span class="fa fa-phone form-control-feedback"></span>
                   </div>
                   <label for="inputEmail1" class="col-lg-2 control-label">Administrador Princ.:</label>
                   <div class="col-md-4 form-group has-feedback">
                    <?php
                      $personales = UserData::getAll();
                      if(count($personales)>0):?>
                        <select name="usuario_id" class="form-control">
                          <option value="">--------------- SELECCIONE GERENTE ----------------</option>
                          <?php foreach($personales as $personal):?>
                            <option value="<?php echo $personal->id_usuario; ?>" <?php if($configuracion->usuario_id==$personal->id_usuario){ echo "selected";} ?>><?php echo $personal->nombre; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php endif; ?>
                   </div>
                </div>
                <hr>
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Titulo:</label>
                   <div class="col-md-4 form-group has-feedback">
                    <input type="text" name="texto1" class="form-control" id="texto1" value="<?php echo $configuracion->texto1; ?>" placeholder="Actualice el Titulo del Icono de la Pagina" onkeypress="return sololetras(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="15">
                    <span class="fa fa-file-text form-control-feedback"></span>
                   </div>
                   <label for="inputEmail1" class="col-lg-2 control-label">Titulo Inicio:</label>
                   <div class="col-md-4 form-group has-feedback">
                    <input type="text" name="texto6" class="form-control" id="texto6" value="<?php echo $configuracion->texto6; ?>" placeholder="Actualice el Titulo del Login"  onkeypress="return sololetras(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="25">
                    <span class="fa fa-file-text form-control-feedback"></span>
                   </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">footer:</label>
                   <div class="col-md-4 form-group has-feedback">
                    <input type="text" name="footer1" class="form-control" id="footer1" value="<?php echo $configuracion->footer1; ?>" placeholder="Actualice el Mini Nombre de la Pagina"  onkeypress="return solonumeros(event)" maxlength="4">
                    <span class="fa fa-file-text form-control-feedback"></span>
                   </div>
                   <label for="inputEmail1" class="col-lg-2 control-label">Imagen:</label>
                   <div class="col-md-4 form-group has-feedback">
                    <input type="file" name="imagen" id="imagen">
                   </div>
                </div>
                <hr>
                <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-3">
                   <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-spinner fa-spin fa-1x fa-left"> </i> Guardar Datos</button>
                  </div>
                  <div class="col-lg-3">
                    <button type="reset" class="btn btn-danger btn-block"><i class="fa fa-eraser"></i> Limpiar Campos</button>
                  </div>
                </div>
                <input type="hidden" name="id_empresa" value="<?php echo $_GET["id_empresa"];?>">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php endif; ?>