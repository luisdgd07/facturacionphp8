<link rel='stylesheet prefetch'
    href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<?php
$u = null;
$tipo = 0;
if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""):
    $u = UserData::getById($_SESSION["admin_id"]);
    if ($u->is_empleado):
        $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
        ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class='fa fa-gift' style="color: orange;"></i>
                    EDITAR RETENCION:
                </h1>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <form action="index.php?action=editaretencion" method="post">
                                <div class="">
                                    <?php $ret = new RetencionData();

                                    $r = $ret->getRetencion($_GET['id']);
                                    ?>
                                    <h2 class="text-center">Retencion de factura N°:<?php echo $r->factura ?> </h2>
                                    <label for="inputEmail1" class="col-lg-2 control-label">Numero de Retención</label>
                                    <div class="col-lg-2 ">
                                        <input type="number" class="form-control" name="ret" id="cantidadPl">


                                    </div>

                                    <label for="inputEmail1" class="col-lg-2 control-label">Timbrado:</label>
                                    <div class="col-lg-2">
                                        <input type="number" class="form-control" name="timbrado" id="cantidadPl">

                                    </div>
                                    <label for="inputEmail1" class="col-lg-2 control-label">Fecha:</label>
                                    <div class="col-lg-2">
                                        <input type="date" class="form-control" name="fecha" id="cantidadPl"
                                            value="<?php echo $r->fecha ?>">

                                    </div>
                                    <input hidden style="display: none" class="form-control" name="id" id="cantidadPl"
                                        value="<?php echo $_GET['id'] ?>">
                                    <input hidden style="display: none" class="form-control" name="id_sucursal" id="cantidadPl"
                                        value="<?php echo $_GET['id_sucursal'] ?>">
                                </div>


                                <div class="form-group">
                                    <div class="col-lg-offset-2">
                                        <label>
                                            <br>
                                            <input type="hidden" name="sucursal_id" id="sucursal_id"
                                                value="<?php echo $sucursales->id_sucursal; ?>">
                                            <!-- <input type="hidden" value="<?php echo $q1; ?>" id="stock_trans" name="stock_trans" /> -->
                                            <button id="accion" type="submit"
                                                class="btn btn-lg btn-success"><b></b>Editar</button></label>
                                        <br>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>
        </div>
        </div>
        </section>

        </div>
    <?php endif ?>
<?php endif ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>