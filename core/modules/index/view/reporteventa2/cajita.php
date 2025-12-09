  <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
  <!-- Content Wrapper. Contains page content -->
  <?php if($u->is_admin):?>
<div class="content-wrapper">
    <section class="content-header">
      <h1> <i class="fa  fa-bar-chart" style="color: orange;"></i> 
        REPORTE DE VENTAS
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
          <form>
            <input type="hidden" name="view" value="reporteventa">
            <div class="row">
            <div class="col-md-3">

            <select name="uso_id" class="form-control">
              <option value="">--  REPORTE POR TODOS --</option>
              <!-- <?php foreach($clients as $p):?>
              <option value="<?php echo $p->cliente_id;?>"><?php if($p->cliente_id!=null){echo $p->getCliente()->nombre." ".$p->getCliente()->apellido;}else{ echo ""; }  ?></option>
              <?php endforeach; ?> -->
            </select>

            </div>
            <div class="col-md-3">
            <input type="date" name="sd" value="<?php if(isset($_GET["sd"])){ echo $_GET["sd"]; }?>" class="form-control">
            </div>
            <div class="col-md-3">
            <input type="date" name="ed" value="<?php if(isset($_GET["ed"])){ echo $_GET["ed"]; }?>" class="form-control">
            </div>

            <div class="col-md-3">
            <input type="submit" class="btn btn-warning btn-block" value="Procesar">
            </div>

            </div>
            </form>
            <div class="row">
  
  <div class="col-md-12">
    <?php if(isset($_GET["sd"]) && isset($_GET["ed"]) ):?>
<?php if($_GET["sd"]!=""&&$_GET["ed"]!=""):?>
      <?php 
      $operations = array();

      if($_GET["uso_id"]==""){
      $operations = VentaData::getAllByDateOfficial($_GET["sd"],$_GET["ed"],2);
      }
      else{
      $operations = VentaData::getAllByDateBCOpp($_GET["uso_id"],$_GET["sd"],$_GET["ed"],2);
      } 


       ?>

       <?php if(count($operations)>0):?>
        <?php $supertotal = 0; ?>
<table class="table table-bordered">
  <thead>

    <th>Subtotal</th>
    <th>Descuento</th>
    <th>Total</th>
    <th>Fecha</th>
  </thead>
<?php foreach($operations as $operation):?>
  <tr>
    <td>Bs <?php echo number_format($operation->total,0,'.','.'); ?></td>
    <td>Bs <?php echo number_format($operation->descuento,0,'.','.'); ?></td>
    <td>Bs <?php echo number_format($operation->total-$operation->descuento,0,'.','.'); ?></td>
    <td><?php echo $operation->fecha; ?></td>
  </tr>
<?php
$supertotal+= ($operation->total-$operation->descuento);
 endforeach; ?>

</table>
<h1>Total : Bs <b><?php echo number_format($supertotal,0,'.','.'); ?></b></h1>

       <?php else:
       // si no hay operaciones
       ?>
<script>
  $("#wellcome").hide();
</script>
<div class="jumbotron">
  <h2>No hay operaciones</h2>
  <p>El rango de fechas seleccionado no proporciono ningun resultado de operaciones.</p>
</div>

       <?php endif; ?>
<?php else:?>
<script>
  $("#wellcome").hide();
</script>
<div class="jumbotron">
  <h2>Fecha Incorrectas</h2>
  <p>Puede ser que no selecciono un rango de fechas, o el rango seleccionado es incorrecto.</p>
</div>
<?php endif;?>

    <?php endif; ?>
  </div>
</div>
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
      <h1> <i class="fa  fa-bar-chart" style="color: orange;"></i> 
        REPORTE DE VENTAS
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
          <form>
            <input type="hidden" name="view" value="reporteventa">
            <div class="row">
            <div class="col-md-3">

            <select name="uso_id" class="form-control">
              <option value="">--  REPORTE POR TODOS --</option>
              <!-- <?php foreach($clients as $p):?>
              <option value="<?php echo $p->cliente_id;?>"><?php if($p->cliente_id!=null){echo $p->getCliente()->nombre." ".$p->getCliente()->apellido;}else{ echo ""; }  ?></option>
              <?php endforeach; ?> -->
            </select>

            </div>
            <div class="col-md-3">
            <input type="date" name="sd" value="<?php if(isset($_GET["sd"])){ echo $_GET["sd"]; }?>" class="form-control">
            </div>
            <div class="col-md-3">
            <input type="date" name="ed" value="<?php if(isset($_GET["ed"])){ echo $_GET["ed"]; }?>" class="form-control">
            </div>

            <div class="col-md-3">
               <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
            <input type="submit" class="btn btn-warning btn-block" value="Procesar">
            </div>

            </div>
            </form>
            <div class="row">
  
  <div class="col-md-12">
    <?php if(isset($_GET["sd"]) && isset($_GET["ed"]) ):?>
<?php if($_GET["sd"]!=""&&$_GET["ed"]!=""):?>
      <?php 
      $operations = array();

      if($_GET["uso_id"]==""){
      $operations = VentaData::getAllByDateOfficial($_GET["sd"],$_GET["ed"],2);
      }
      else{
      $operations = VentaData::getAllByDateBCOpp($_GET["uso_id"],$_GET["sd"],$_GET["ed"],2);
      } 


       ?>

       <?php if(count($operations)>0):?>
        <?php $supertotal = 0; ?>
<table class="table table-bordered">
  <thead>

    <th>Subtotal</th>
    <th>Descuento</th>
    <th>Total</th>
    <th>Fecha</th>
  </thead>
<?php foreach($operations as $operation):?>
  <tr>
    <?php if ($operation->sucursal_id==$sucursales->id_sucursal): ?>
      <td>Bs <?php echo number_format($operation->total,0,'.','.'); ?></td>
      <td>Bs <?php echo number_format($operation->descuento,0,'.','.'); ?></td>
      <td>Bs <?php echo number_format($operation->total-$operation->descuento,0,'.','.'); ?></td>
      <td><?php echo $operation->fecha; ?></td>
      <?php else: ?>
    <?php endif ?>
   
  </tr>
<?php
$supertotal+= ($operation->total-$operation->descuento);
 endforeach; ?>

</table>
<h1>Total : Bs <b><?php echo number_format($supertotal,0,'.','.'); ?></b></h1>

       <?php else:
       // si no hay operaciones
       ?>
<script>
  $("#wellcome").hide();
</script>
<div class="jumbotron">
  <h2>No hay operaciones</h2>
  <p>El rango de fechas seleccionado no proporciono ningun resultado de operaciones.</p>
</div>

       <?php endif; ?>
<?php else:?>
<script>
  $("#wellcome").hide();
</script>
<div class="jumbotron">
  <h2>Fecha Incorrectas</h2>
  <p>Puede ser que no selecciono un rango de fechas, o el rango seleccionado es incorrecto.</p>
</div>
<?php endif;?>

    <?php endif; ?>
  </div>
</div>
        </div>
      </div>
    </section>
  </div>
  <?php endif ?>
<?php endif ?>