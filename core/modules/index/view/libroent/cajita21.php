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
                    VENTAS REALIZADAS
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
                    REGISTRO DE VENTAS
                </h1>

            </section>

            <!-- Main content -->

            <div class="row">
                <section class="content">

                    <div class="col-xs-12">
                        <div class="box">
                           
                           <div class="col-md-3">
                            <select name="tipofactura" id="tipofactura" class="form-control">
                                 <option value="">SELECCIONAR FORMA DE PAGO</option>
								  <option value="todos">todos</option>
								  <option value="contado">contado</option>
								  <option value="credito">credito</option>
								 
                                </select>
								
								
                           	</div>
                           <div class="col-md-3">

                              <select name="product" id="product" class="form-control">
                                 <option value="">SELECCIONAR PRODUCTO</option>
							
								 
                                </select>

                           	</div>



                            


						   <div class="col-md-3">


                                <select name="cliente_id" id="cliente_id" class="form-control">
                                   
                                <option value="">SELECCIONAR CLIENTE</option>
								   <?php $clientes = ClienteData::verclientessucursal($sucursales->id_sucursal);
                                    if (count($clientes) > 0) {
                                        foreach ($clientes as $p) : ?>
                                            <option value="<?php echo $p->id_cliente; ?>"><?php echo $p->nombre . " " . $p->apellido; ?></option>
                                    <?php endforeach;
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
							
							 <h5>
                    DESDE:
                </h5>
                                <input type="date" name="sd" id="date1" value="" class="form-control"> 
								
								
									 <h5>
                    HASTA:
                </h5>
                      
                           
                                <input type="date" name="ed" id="date2" value="" class="form-control"> 

                                <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                            </div>


                            <button onclick="exportar()" href="" class="mx-4 my-2 btn btn-success">Generar PDF</button>
                            <button onclick="exportar2()" href="" class="mx-4 my-2 btn btn-success">Generar Excel</button>
                            <script>
                                function exportar() {
                                    date1 = document.getElementById("date1").value;
                                    date2 = document.getElementById("date2").value;
                                    cliente = document.getElementById("cliente_id").value;
                                    id_sucursal = document.getElementById("id_sucursal").value;
                                    window.location.href = `libroVenta1.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&cliente=${cliente}`;




                                }


                                function exportar2() {
                                    date1 = document.getElementById("date1").value;
                                    date2 = document.getElementById("date2").value;
                                    cliente = document.getElementById("cliente_id").value;
                                    id_sucursal = document.getElementById("id_sucursal").value;
                                    window.location.href = `csvVenta.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}&cliente=${cliente}`;
                                }

                                function exportar3() {
                                    date1 = document.getElementById("date1").value;
                                    date2 = document.getElementById("date2").value;
                                    id_sucursal = document.getElementById("id_sucursal").value;
                                    window.location.href = `csvVenta3.php?&uso_id=&sd=${date1}&ed=${date2}&id_sucursal=${id_sucursal}`;
                                }
                            </script>
                        </div>
                    </div>
            </div>
            </section>
        </div>
    <?php endif ?>
<?php endif ?>