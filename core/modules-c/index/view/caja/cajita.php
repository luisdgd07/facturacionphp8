 <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
  <!-- Content Wrapper. Contains page content -->
  <?php if($u->is_admin):?>
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
        <div class="box-body">
          <p class="alert alert-danger"><i style="color: yellow;" class="glyphicon glyphicon-warning-sign"></i> Hola, por favor tener mucho cuidado, con el cierre de Caja
          </p>
          <center>
            <a href="index.php?view=cajaventa" data-toggle="modal" class="btn btn-info btn-sm"> CAJA VENTAS</a>
            <!-- <a href="index.php?view=cajachica" data-toggle="modal" class="btn btn-success btn-sm"> CAJA CHICA</a> -->
          </center>
        </div>
      </div>
    </section>
  </div>
    <?php endif ?>
    <?php if($u->is_empleado):?>
      <?php
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
  ?>
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
        <div class="box-body">
          <p class="alert alert-danger"><i style="color: yellow;" class="glyphicon glyphicon-warning-sign"></i> Hola, por favor tener mucho cuidado, con el cierre de Caja
          </p>
          <center>
            <a href="index.php?view=cajaventa&id_sucursal=<?php echo $sucursales->id_sucursal;?>" data-toggle="modal" class="btn btn-success btn-sm"> CAJA VENTAS</a>
            <!-- <a href="index.php?view=cajachica" data-toggle="modal" class="btn btn-success btn-sm"> CAJA CHICA</a> -->
          </center>
        </div>
      </div>
    </section>
  </div>
    <?php endif ?>
<?php endif ?>