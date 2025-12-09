 <?php
  $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
  ?>
 <div class="content-wrapper">
   <section class="content-header">
     <h1><i class='fa fa-laptop' style="color: orange;"></i>
       REGISTRO DE VENDEDOR
     </h1>
   </section>
   <!-- Main content -->
   <section class="content">

     <div class="row">

       <div class="col-xs-12">
         <form method="post" action="index.php?action=creavendedor" role="form">
           <div class="box">
             <div class="box-body">
               <div class="box box-warning">
                 <div class="panel-body">
                   <div class="form-horizontal">





                     <div class="form-group has-feedback has-warning">

                       <label class="col-lg-2 control-label">Nombre:</label>
                       <div class="col-lg-4">
                         <input type="text" name="nombre" class="form-control" id="descripcion" maxlength="800">
                         <span class="fa fa-dollar form-control-feedback"></span>
                       </div>


                     </div>
                     <div class="form-group has-feedback has-warning">

                       <label for="cuota" class="col-lg-2 control-label">Dirección:</label>
                       <div class="col-lg-4">
                         <input type="text" name="direccion" class="form-control" id="cuota" required>
                         <span class="fa fa-barcode form-control-feedback"></span>
                       </div>
                       <label class="col-lg-2 control-label">Cedula</label>
                       <div class="col-lg-4">
                         <input type="text" name="cedula" class="form-control" id="monto" maxlength="800" required>
                         <span class="fa fa-laptop form-control-feedback"></span>
                       </div>



                     </div>




                   </div>
                   <div class="form-group">
                     <div class="col-lg-offset-2 col-lg-10">
                       <input type="hidden" name="sucursal" id="sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                       <input type="hidden" name="sucursal_id" id="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
                       <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
                     </div>
                   </div>
                   <div id="insumos"></div>
                 </div>
               </div>
             </div>
           </div>
       </div>
       </form>

     </div>

 </div>
 </section>
 </div>
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
 </script>