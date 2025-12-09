 <?php if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"]!=""):?>
            <?php 
            $u=null;
            if($_SESSION["admin_id"]!=""){
          $u = UserData::getById($_SESSION["admin_id"]);
          // $user = $u->nombre." ".$u->apellido;
          }?>
 <?php
$cliente = ConfigFacturaData::VerId($_GET["id_configfactura"]);
// $url = "storage/plato/".$cliente->id_plato."/".$cliente->imagen;
?>
 <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-steam' style="color: orange;"></i>
        ACTUALIZACIÓN DE LA FACTURA: <b style="color: orange;"><?php echo $cliente->serie1; ?></b>
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
                      <form class="form-horizontal" action="index.php?action=actualizarfiguracionfactura1" role="form" method="post" enctype="multipart/form-data">
                        <!-- <form class="form-horizontal" action="index.php?action=actualizarcategoria1" role="form" method="post" enctype="multipart/form-data"> -->
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Comprobante</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="comprobante1" name="comprobante1">
                        <option value="<?php echo $cliente->comprobante1 ?>"><?php echo $cliente->comprobante1 ?></option>
                        <?php if ($cliente->comprobante1=="Factura"): ?>
                          <?php else: ?>
                            <option value="Factura">Factura</option>
                        <?php endif ?>
                        <?php if ($cliente->comprobante1=="Remision"): ?>
                          <?php else: ?>
                            <option value="Remision" >Remision</option>
                        <?php endif ?>
                        <?php if ($cliente->comprobante1=="Recibo"): ?>
                          <?php else: ?>
                            <option value="Recibo">Recibo</option>
                        <?php endif ?>
                        <?php if ($cliente->comprobante1=="Masiva"): ?>
                          <?php else: ?>
                            <option value="Masiva">Masiva</option>
                        <?php endif ?><?php if ($cliente->comprobante1=="Masiva"): ?>
                          <?php else: ?>
                            <option value="Nota de Debito" disabled="">Nota de Debito</option>
                        <?php endif ?><?php if ($cliente->comprobante1=="Nota de Credito"): ?>
                          <?php else: ?>
                            <option value="Nota de Credito" disabled="">Nota de Credito</option>
                        <?php endif ?>
                      </select>
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Serie</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" value="<?php echo $cliente->serie1?>" id="serie1" name="serie1" required  onpaste="return false" maxlength="10">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Timbrado</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" value="<?php echo $cliente->timbrado1 ?>" id="timbrado1" name="timbrado1" required onkeypress="return solonumeross(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Numero Actual</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" value="<?php echo $cliente->numeracion_final-$cliente->diferencia ?>" id="numeroactual1" name="numeroactual1" required onkeypress="return solonumeross(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">N°. Inicial</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="<?php echo $cliente->numeracion_inicial ?>" id="numeracion_inicial" name="numeracion_inicial"  onkeypress="return solonumeross(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500">
                    </div>
                    <label for="inputEmail1" class="col-sm-2 control-label">N°. Final</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" value="<?php echo $cliente->numeracion_final ?>" id="numeracion_final" name="numeracion_final"  onkeypress="return solonumeross(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500" >
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Ini Timbrado</label>
                    <div class="col-sm-4">
                      <input type="date" class="form-control" value="<?php echo $cliente->inicio_timbrado ?>" id="inicio_timbrado" name="inicio_timbrado"   maxlength="500">
                    </div>
                    <label for="inputEmail1" class="col-sm-2 control-label">Fin Timbrado</label>
                    <div class="col-sm-3">
                      <input type="date" class="form-control" value="<?php echo $cliente->fin_timbrado ?>" id="fin_timbrado" name="fin_timbrado" maxlength="500" >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="sucursal_id" value="<?php echo $cliente->id_sucursal; ?>">
              <input type="hidden" name="id_configfactura" value="<?php echo $cliente->id_configfactura; ?>">
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