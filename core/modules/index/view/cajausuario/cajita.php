 <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
    <?php if($u->is_empleado):?>
      <?php
    $usuarios = UserData::getById($_GET["id_usuario"]);
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
  ?>
  <?php $fech_actual=date("d-m-y"); ?>
  <?php $hora_actual=date("H:i:s"); ?>
<div class="content-wrapper">
    <section class="content-header">
      <h1> <i class="fa fa-cube" style="color: orange;"></i> 
        CAJA
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <div class="box-tools pull-left">
            <a href="index.php?view=caja" data-toggle="modal" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></a>
          </div>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <label><?php echo $fech_actual ?></label>
        <div class="box-body">
          <p class="alert alert-danger"><i style="color: yellow;" class="glyphicon glyphicon-warning-sign"></i> Hola, por favor tener mucho cuidado, con el cierre de Caja
          </p>
          <form action="index.php?action=cajainicialporusuario" method="post" accept-charset="utf-8">
            Monto Inicial: <input type="number" name="montoinicial" class="form-comtrol">
            <input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $usuarios->id_usuario ?>" class="form-comtrol">
            <input type="hidden" name="sucursal_id" id="sucursal_id" value="<?php echo $sucursales->id_sucursal ?>" class="form-comtrol">
             <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $usuarios->id_usuario ?>" class="form-comtrol">
            <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal ?>" class="form-comtrol">
            <button type="submit" class="btn btn-info">registrar Monto Inicial</button>
          </form>
           <?php
              $cajas = CajaData::vercajapersonal($usuarios->id_usuario);
              if(count($cajas)>0){
            ?>
            <?php foreach ($cajas as $caja): ?>
          <center>
            <a href="index.php?view=cajaventausuario&id_caja=<?php echo $caja->id_caja;?>&id_usuario=<?php echo $usuarios->id_usuario;?>&id_sucursal=<?php echo $sucursales->id_sucursal;?>" data-toggle="modal" class="btn btn-success btn-sm"> CAJA VENTAS</a>
          </center>
            <?php endforeach ?>
          <?php } ?>
          
        </div>
      </div>
    </section>
  </div>
    <?php endif ?>
<?php endif ?>