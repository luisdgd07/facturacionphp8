<?php
$u = null;
if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
    $u = UserData::getById($_SESSION["admin_id"]);
?>
    <!-- Content Wrapper. Contains page content -->
    <?php if ($u->is_admin) : ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
                    REPORTE LIBRO VENTAS
                </h1>
            </section>
            <!-- Main content -->
            <section class="content">
            </section>
        </div>
    <?php endif ?>
    <?php if ($u->is_empleado) : ?>

        <?php
		
		
		$sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
        ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
                    REPORTE LIBRO VENTAS
                </h1>

            </section>

            <!-- Main content -->

            <div class="row">
                <section class="content">

                    <div class="col-xs-12">
                        <div class="box">
                            <div class="col-md-3">
                                <input type="date" name="sd" id="date1" value="" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="ed" id="date2" value="" class="form-control">
								
							
                                <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                            </div>

                            <button onclick="exportar()" href="" class="mx-4 my-2 btn btn-success">Exportar Libro ventas</button>
                            <script>
                              
                                function exportar(){
                                    date1 = document.getElementById("date1").value;
                                    date2=document.getElementById("date2").value;
									id_sucursal=document.getElementById("id_sucursal").value;
                                    window.location.href=`csvVenta.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}`;
                                }
                            </script>
                        </div>
                    </div>
            </div>
            </section>
			
			
			
        </div>
    <?php endif ?>
<?php endif ?>