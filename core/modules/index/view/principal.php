<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php
  $config = ConfigData::getAll();
  if (count($config) > 0) {

    foreach ($config as $configuracion) { ?>
      <title><?php echo $configuracion->texto1; ?></title>
      <?php
    }
  } else {
  }
  ?>

  <script src="plugins/jquery/jquery-2.1.4.min.js"></script>


</head>

<body
  class="<?php if (isset($_SESSION["admin_id"]) || isset($_SESSION["id_usuario"])): ?> hold-transition skin-blue sidebar-collapse<?php else: ?>login-page<?php endif; ?>"
  oncopy="return true" onpaste="return true">
  <div class="wrapper">
    <?php
    $u = null;
    if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""):
      $u = UserData::getById($_SESSION["admin_id"]);
      $url = "storage/admin/" . $u->imagen;
      $configuracion = ConfigData::getAll();
      $timezone = 'America/Bogota';
      date_default_timezone_set($timezone);

      $range_to = date('m/d/Y');
      $range_from = date('m/d/Y', strtotime('-30 day', strtotime($range_to)));
      ?>


      <div class="wrapper">
        <header class="main-header">
          <a href="./" class="logo">
            <span class="logo-mini"><b>R</b>&C</span>
            <?php
            $config = ConfigData::getAll();
            if (count($config) > 0) {
              ?>
              <?php
              foreach ($config as $configuracion) { ?>
                <span class="logo-lg"><b><?php echo $configuracion->nombre; ?></b></span>
                <?php
              }
            } else {
            }
            ?>
          </a>
          <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
              <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php if ($u->imagen != "" && file_exists($url)): ?>
                      <img src="<?php echo $url; ?>" class="user-image" alt="User Image">
                    <?php endif; ?>
                    <span class="hidden-xs"><?php echo $u->nombre . " " . $u->apellido; ?></span>
                  </a>
                  <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                      <?php if ($u->imagen != "" && file_exists($url)): ?>
                        <img src="<?php echo $url; ?>" class="img-circle" alt="User Image">
                      <?php endif; ?>
                      <p>
                        <?php echo $u->nombre . " " . $u->apellido; ?>
                        <small>Miembro desde: <?php echo $u->fecha; ?></small>
                      </p>
                    </li>
                    <li class="user-footer">
                      <div class="pull-left">
                        <a href="index.php?view=actualizarperfil" class="btn btn-default btn-flat">Perfil</a>
                      </div>
                      <div class="pull-right">
                        <a href="salir.php" class="btn btn-default btn-flat">Salir</a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
          <!-- sidebar: style can be found in sidebar.less -->
          <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
              <div class="pull-left image">
                <?php
                $config = ConfigData::getAll();
                if (count($config) > 0) {
                  ?>
                  <?php
                  foreach ($config as $configuracion) {
                    $url = "storage/sis/admin/" . $configuracion->logo;
                    ?>

                    <?php if ($configuracion->logo != "" && file_exists($url)): ?>
                      <img src="<?php echo $url; ?>" class="img-circle" alt="User Image">
                    <?php endif; ?>
                    <?php
                  }
                } else {
                }
                ?>

                <!-- FIN DEL MENU -->
              </div>
              <div class="pull-left info">
                <p><?php echo $u->nombre . " " . $u->apellido; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
              </div>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
              <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                    <i class="fa fa-search"></i>
                  </button>
                </span>
              </div>
            </form>

            <?php if ($u->is_admin): ?>
              <ul class="sidebar-menu" data-widget="tree">


                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-building-o" style="color: yellow;"></i> <span> EMPRESA</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="index.php?view=sucursal"><i class="fa fa-cogs" style="color: orange;"></i> Nuevo</a></li>


                  </ul>
                </li>

                <li class="header"><i class="fa fa-windows" style="color: orange;"></i> USUARIOS - CAJA</li>
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-user-secret" style="color: yellow;"></i> <span> USUARIOS</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">

                    <li><a href="index.php?view=administrador"><i class="fa fa-user-secret" style="color: orange;"></i>
                        Usuarios</a></li>
                  </ul>
                </li>

                <li class="header"><i class="fa fa-image" style="color: orange;"></i> REPORTE EN GENERAL</li>
                <li class="treeview">
                  <a href="#">
                    <i class="fa  fa-line-chart" style="color: yellow;"></i> <span> REPORTES</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="index.php?view=reporte_venta_general"><i class="fa fa-bar-chart-o"
                          style="color: orange;"></i> Reporte Ventas por Empresa</a></li>

                  </ul>
                </li>
                <li class="header"><i class="fa fa-windows" style="color: orange;"></i> MENU NAVEGACIONAL</li>
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-gears" style="color: yellow;"></i> <span>CONFIGURACIÓN</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="index.php?view=config"><i class="fa fa-gear" style="color: orange;"></i> Configuración</a>
                    </li>
                  </ul>
                </li>
              </ul>
            <?php endif;
            if ($u->sucursal_id == 2) {
              $usuarioss = UserData::getById($u->id_usuario);
              $sucursales = SucursalUusarioData::verusucursalusuarios($usuarioss->id_usuario);
              if (count($sucursales) > 0):
                foreach ($sucursales as $sucur):
                  $sucursal = $sucur->verSocursal(); ?>

                  <ul class="sidebar-menu" data-widget="tree">
                    <li class="header"
                      style="font-size: 15px; margin: auto; text-align: center; color: #FFA200; border: 7px solid #FF0000;">
                      <i></i><?php echo $sucursal->nombre; ?>
                    </li>
                    <li class="active">
                      <a href="index.php?view=remision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>">
                        <i class="fa fa-money" style="color: yellow;"></i> <span>
                          <!-- <b style="color: yellow;">Bs</b> --> REALIZAR REMISION
                        </span>
                        <span class="pull-right-container">
                          <small class="label pull-right bg-yellow">REMISION</small>
                        </span>
                      </a>
                    </li>
                    <li class="active">
                      <a href="index.php?view=remision1&id_sucursal=<?php echo $sucursal->id_sucursal; ?>">
                        <i class="fa fa-laptop" style="color: yellow;"></i> <span>REMISIONES PENDIENTES</span>
                        <span class="pull-right-container">
                          <small class="label pull-right bg-yellow">PENDIENTES</small>
                        </span>
                      </a>
                    </li>



                    <li class="active">
                      <a href="index.php?view=envioventaremision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>">
                        <i class="fa fa-laptop" style="color: yellow;"></i> <span>ENVIAR VENTA C/ REMISION</span>
                        <span class="pull-right-container">
                          <small class="label pull-right bg-yellow">ENVIAR VENTA C/ REMISION</small>
                        </span>
                      </a>
                    </li>


                    <li class="header"><i class="fa fa-windows" style="color: orange;"></i> VENTAS</li>


                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span> CLIENTES</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">

                        <li><a href="index.php?view=cliente&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-user" style="color: orange;"></i> Clientes</a></li>

                        <?php if ($u->opciones == 1) { ?>



                          <li><a href=""><i class="fa fa-money" style="color: orange;"></i>Estado de cuenta general</a></li>
                          <li><a href=""><i class="fa fa-money" style="color: orange;"></i>Estado de cuenta detallado</a></li>



                        <?php } ?>

                      </ul>
                    </li>


                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span> REMISION</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="index.php?view=remision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i> Realizar Remisión</a></li>
                        <li><a href="index.php?view=remision1&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i> Rem. pendientes locales</a></li>
                        <li><a href="index.php?view=remisionexport&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i> Rem. pendientes a Exportar</a></li>



                        <li><a href="index.php?view=remision2&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i> Listado de Remisiones </a></li>
                        <li><a href="index.php?view=envioremision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i> Envio de Remisiones a Sifen </a></li>
                        <li><a href="index.php?view=envioventaremision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i> Envio de Ventas a Sifen </a></li>
                      </ul>
                    </li>
                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span> VENTAS</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">

                        <li><a href="index.php?view=vender&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i> Realizar Venta local</a></li>
                        <li><a href="index.php?view=ventas&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Listado de Ventas</a></li>


                        <li><a href="index.php?view=envioporlote&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Enviar a Sifen</a></li>
                        <li><a href="index.php?view=cobrocaja&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Cobro Caja</a></li>
                        <li><a href="index.php?view=cobros&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Cobros</a></li>

                        <li><a href="index.php?view=listacredito&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Credito Clientes</a></li>
                        <li><a href="index.php?view=tarjeta&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i>Tarjeta</a></li>

                        <li><a href="index.php?view=retencion&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i>Retención</a></li>
                        <li><a href="index.php?view=cuentabancaria&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Movimiento Bancario </a></li>


                      </ul>
                    </li>


                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span>NOTA DE CREDITO</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">

                        <li><a href="index.php?view=nota_de_credito&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> listado de Notas de Credito</a></li>

                        <li><a href="index.php?view=envionotacredito&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Envios a Sifen</a></li>

                      </ul>
                    </li>
                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span>VENTA DE EXPORTACIÓN</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="index.php?view=venderproforma&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i>Realizar Proforma</a></li>
                        <li><a href="index.php?view=venderexport&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i>Realizar Exportación</a></li>

                        <li><a href="index.php?view=ventasproforma&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i>Listado de Proformas</a></li>
                        <li><a href="index.php?view=ventasexportacion&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i>Listado de Exportaciones</a></li>
                        <li><a href="index.php?view=envioexportacion&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i>Enviar a Sifen.</a></li>

                      </ul>
                    </li>



                    <li class="header"><i class="fa fa-windows" style="color: orange;"></i> COBRANZA CLIENTES</li>
                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span> COBRANZA</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-money" style="color: orange;"></i>Cobranza</a></li>
                        <li><a href=""><i class="fa fa-cart-plus" style="color: orange;"></i>listado de Cobranzas</a></li>

                        <li><a href=""><i class="fa fa-cart-plus" style="color: orange;"></i>listado de Retenciones</a></li>

                      </ul>
                    </li>

                    <li class="header"><i class="fa fa-windows" style="color: orange;"></i> MANTENIMIENTO</li>






                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-android" style="color: yellow;"></i> <span> PRODUCTOS</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <!-- index.php?view=reporteproductoss&id_sucursal=17 -->
                        <li><a href="index.php?view=nuevoproducto1&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-laptop" style="color: orange;"></i>Nuevo producto</a></li>
                        <li><a href="index.php?view=producto&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-laptop" style="color: orange;"></i> Lista de Productos</a></li>
                        <li><a href="index.php?view=categoria&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa  fa-steam" style="color: orange;"></i> Categoria</a></li>
                        <li><a href="index.php?view=marca&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa  fa-steam" style="color: orange;"></i> Marca</a></li>
                        <li><a href="index.php?view=grupos&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa  fa-steam" style="color: orange;"></i> Grupos</a></li>
                      </ul>
                    </li>


                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-building-o" style="color: yellow;"></i> <span> INVENTARIO</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="index.php?view=inventario&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa  fa-heartbeat" style="color: orange;"></i>Stock de Productos</a></li>
                        <!-- <li><a href="index.php?view=ajustarstock&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-cogs" style="color: orange;"></i> Realizar Compra</a></li> -->

                        <li><a href="index.php?view=transacciones&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i> Movimiento de Stock</a></li>
                        <li><a href="index.php?view=transa&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i> Transacciones</a></li>
                        <li><a href="index.php?view=transacioness&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i> Transacciones por producto</a></li>
                      </ul>
                    </li>

                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-building-o" style="color: yellow;"></i> <span> CONFIGURACIONES</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">

                        <li><a href="index.php?view=moneda&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i> Moneda</a></li>

                        <li><a href="index.php?view=cotizacion&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Cotización</a></li>
                        <li><a href="index.php?view=tipo_producto&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Tipo Producto</a></li>
                        <li><a href="index.php?view=deposito&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Depósito</a></li>

                        <?php if ($u->opciones == 1) { ?>
                          <li><a href="index.php?view=cofigfactura&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                                class="fa fa-cogs" style="color: orange;"></i> Config. Factura</a></li>
                        <?php } ?>




                        <li><a href=""><i class="fa fa-cogs" style="color: orange;"></i>Lista de Precios</a></li>
                        <li><a href=""><i class="fa fa-cogs" style="color: orange;"></i>Precio de Productos</a></li>
                        <li><a href="index.php?view=choferes&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Choferes</a></li>

                        <li><a href="index.php?view=vehiculos&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Vehiculos</a></li>

                        <li><a href="index.php?view=agente&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Agentes</a></li>
                        <li><a href="index.php?view=fletera&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Empresa fletera</a></li>
                        <li><a href="index.php?view=vended&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Vendedor</a></li>

                      </ul>
                    </li>





                    <li class="header"><i class="fa fa-windows" style="color: orange;"></i> CAJA</li>
                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-cube" style="color: yellow;"></i> <span> CAJA</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">


                        <li><a href=""><i class="fa fa-cart-plus" style="color: orange;"></i>Iniciar Caja</a></li>
                      </ul>
                    </li>
                    <li class="header"><i class="fa fa-image" style="color: orange;"></i> REPORTE EN GENERAL</li>
                    <li class="treeview">
                      <a href="#">
                        <i class="fa  fa-line-chart" style="color: yellow;"></i> <span> REPORTES</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="index.php?view=libroop&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte entradas y salidas </a></li>

                        <li><a href="index.php?view=libroventag&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte Ventas Electronicas</a></li>


                        <?php if ($u->opciones == 1) { ?>
                          <li><a href="index.php?view=libroestadocobros&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                                class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte Cobranzas </a></li>
                        <?php } ?>

                        <li><a href="index.php?view=reportestockproductos&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-bar-chart-o" style="color: orange;"></i>Reporte de productos general</a></i></li>

                        <li><a href="index.php?view=reporteresolucion&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte Resolución 90</a></i></li>


                        <li>
                          <?php if ($u->sucursal_id == 17) { ?>
                            <a target="_BLANK" href="http://localhost:84/importacion_mercury/"><i class="fa fa-bar-chart-o"
                                style="color: orange;"></i>Exportar Ventas Electrónicas</a>
                          <?php }
                          if ($u->sucursal_id == 18) { ?>
                            <a target="_BLANK" href="http://localhost:84/importacion_bravo/"><i class="fa fa-bar-chart-o"
                                style="color: orange;"></i>Exportar Ventas Electrónicas</a>

                          <?php }
                          if ($u->sucursal_id == 22) { ?>
                            <a target="_BLANK" href="http://localhost:84/importacion_dosbeta/"><i class="fa fa-bar-chart-o"
                                style="color: orange;"></i>Exportar Ventas Electrónicas</a>

                          <?php } ?>


                        </li>

                      </ul>
                    </li>
                  </ul>

                <?php endforeach ?>
              <?php endif;
            } else { ?>


              <?php
              $usuarioss = UserData::getById($u->id_usuario);
              $sucursales = SucursalUusarioData::verusucursalusuarios($usuarioss->id_usuario);
              ?>
              <?php if (count($sucursales) > 0): ?>
                <?php foreach ($sucursales as $sucur):
                  $sucursal = $sucur->verSocursal(); ?>

                  <ul class="sidebar-menu" data-widget="tree">
                    <li class="header"
                      style="font-size: 15px; margin: auto; text-align: center; color: #FFA200; border: 7px solid #FF0000;">
                      <i></i><?php echo $sucursal->nombre; ?>
                    </li>
                    <li class="active">
                      <a href="index.php?view=remision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>">
                        <i class="fa fa-money" style="color: yellow;"></i> <span>
                          <!-- <b style="color: yellow;">Bs</b> --> REALIZAR REMISION
                        </span>
                        <span class="pull-right-container">
                          <small class="label pull-right bg-yellow">REMISION</small>
                        </span>
                      </a>
                    </li>
                    <li class="active">
                      <a href="index.php?view=remision1&id_sucursal=<?php echo $sucursal->id_sucursal; ?>">
                        <i class="fa fa-laptop" style="color: yellow;"></i> <span>REMISIONES PENDIENTES</span>
                        <span class="pull-right-container">
                          <small class="label pull-right bg-yellow">PENDIENTES</small>
                        </span>
                      </a>
                    </li>



                    <li class="active">
                      <a href="index.php?view=envioventaremision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>">
                        <i class="fa fa-laptop" style="color: yellow;"></i> <span>ENVIAR VENTA C/ REMISION</span>
                        <span class="pull-right-container">
                          <small class="label pull-right bg-yellow">ENVIAR VENTA C/ REMISION</small>
                        </span>
                      </a>
                    </li>









                    <li class="header"><i class="fa fa-windows" style="color: orange;"></i> VENTAS</li>




                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span> CLIENTES</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">

                        <li><a href="index.php?view=cliente&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-user" style="color: orange;"></i> Clientes</a></li>

                        <li><a href="index.php?view=estadodecuenta&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i>Estado de cuenta general</a></li>
                        <li><a href="index.php?view=libroestado&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i>Estado de cuenta detallado</a></li>

                        <li><a href="index.php?view=nuevocontrato&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i>Nuevo Contrato</a></li>

                        <li><a href="index.php?view=contratos&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i>Contratos</a></li>

                        <li><a
                            href="index.php?view=listadocontratoscliente2&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i>listado conceptos por Contratos</a></li>




                        <li><a
                            href="index.php?view=listadocontratoscliente&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i>Listado conceptos por clientes</a></li>
                        <?php if ($u->opciones == 1) { ?>



                          <li><a href="index.php?view=estadodecuenta&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                                class="fa fa-money" style="color: orange;"></i>Estado de cuenta general</a></li>
                          <li><a href="index.php?view=libroestado&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                                class="fa fa-money" style="color: orange;"></i>Estado de cuenta detallado</a></li>

                        <?php } ?>

                      </ul>
                    </li>



                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span> REMISION</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="index.php?view=remision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i> Realizar Remisión</a></li>
                        <li><a href="index.php?view=remision1&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i> Remisiones pendientes</a></li>

                        <li><a href="index.php?view=listadoplacas&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Listado de Placas</a></li>
                        <li><a href="index.php?view=remision2&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i> Remisiones </a></li>
                        <li><a href="index.php?view=envioremision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i> Envio de Remisión </a></li>
                        <li><a href="index.php?view=envioventaremision&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i> Envio de Venta c/ Remisión </a></li>
                      </ul>
                    </li>
                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span> VENTAS</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">

                        <li><a href="index.php?view=vender&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i> Realizar Venta</a></li>
                        <li><a href="index.php?view=ventas&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Ventas</a></li>
                        <li><a href="index.php?view=vender2&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-money" style="color: orange;"></i> Realizar Venta Contrato</a></li>


                        <li><a href="index.php?view=masiva&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Ventas Masivas</a></li>


                        <li><a href="index.php?view=ventas-masiva-detalle&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Detalles Ventas Masivas</a></li>
                        <li><a href="index.php?view=envioporlote&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Envios a SIFEN</a></li>
                        <li><a href="index.php?view=cobrocaja&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Cobro Caja</a></li>
                        <li><a href="index.php?view=cobros&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Cobros</a></li>

                        <li><a href="index.php?view=listacredito&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Credito Clientes</a></li>
                        <li><a href="index.php?view=tarjeta&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i>Tarjeta</a></li>

                        <li><a href="index.php?view=retencion&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i>Retención</a></li>
                        <li><a href="index.php?view=cuentabancaria&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Movimiento Bancario </a></li>






                      </ul>
                    </li>


                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span>NOTA DE CREDITO</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">

                        <li><a href="index.php?view=nota_de_credito&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Notas de Credito</a></li>

                        <li><a href="index.php?view=envionotacredito&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i> Envios a SIFEN</a></li>

                      </ul>
                    </li>




                    <?php if ($u->opciones == 1) { ?>
                      <li class="header"><i class="fa fa-windows" style="color: orange;"></i> COBRANZA CLIENTES</li>
                      <li class="treeview">
                        <a href="#">
                          <i class="fa fa-shopping-cart" style="color: yellow;"></i> <span> COBRANZA</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="index.php?view=cobranza1&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                                class="fa fa-money" style="color: orange;"></i>Cobranza</a></li>
                          <li><a href="index.php?view=cobros_realizados&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                                class="fa fa-cart-plus" style="color: orange;"></i>listado de Cobranzas</a></li>

                          <li><a href="index.php?view=listaretenciones&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                                class="fa fa-cart-plus" style="color: orange;"></i>listado de Retenciones</a></li>

                        </ul>
                      </li>
                    <?php } ?>

                    <li class="header"><i class="fa fa-windows" style="color: orange;"></i> MANTENIMIENTO</li>






                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-android" style="color: yellow;"></i> <span> PRODUCTOS</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="index.php?view=nuevoproducto1&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-laptop" style="color: orange;"></i>Nuevo producto</a></li>
                        <li><a href="index.php?view=producto&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-laptop" style="color: orange;"></i> Lista de Productos</a></li>
                        <li><a href="index.php?view=categoria&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa  fa-steam" style="color: orange;"></i> Categoria</a></li>
                        <li><a href="index.php?view=marca&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa  fa-steam" style="color: orange;"></i> Marca</a></li>
                        <li><a href="index.php?view=grupos&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa  fa-steam" style="color: orange;"></i> Grupos</a></li>

                      </ul>
                    </li>


                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-building-o" style="color: yellow;"></i> <span> INVENTARIO</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="index.php?view=inventario&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa  fa-heartbeat" style="color: orange;"></i>Stock de Productos</a></li>
                        <!-- <li><a href="index.php?view=ajustarstock&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i class="fa fa-cogs" style="color: orange;"></i> Realizar Compra</a></li> -->

                        <li><a href="index.php?view=transacciones&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i> Movimiento de Stock</a></li>
                        <li><a href="index.php?view=transa&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i> Transacciones</a></li>
                        <li><a href="index.php?view=transacioness&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i> Transacciones por producto</a></li>
                      </ul>
                    </li>

                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-building-o" style="color: yellow;"></i> <span> CONFIGURACIONES</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">

                        <li><a href="index.php?view=moneda&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i> Moneda</a></li>
                        <li><a href="index.php?view=cotizacion&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i> Cotización</a></li>
                        <li><a href="index.php?view=cofigfactura&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i> Config. Factura</a></li>
                        <li><a href="index.php?view=configmasiva&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i> Config. Masiva</a></li>
                        <li><a href="index.php?view=tipo_producto&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Tipo Producto</a></li>
                        <li><a href="index.php?view=deposito&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Depósito</a></li>
                        <li><a href="index.php?view=lista_precio&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Lista de Precios</a></li>
                        <li><a href="index.php?view=producto_precio&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Precio de Productos</a></li>
                        <li><a href="index.php?view=choferes&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Choferes</a></li>
                        <li><a href="index.php?view=vended&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Vendedor</a></li>

                        <li><a href="index.php?view=vehiculos&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-cogs" style="color: orange;"></i>Vehiculos</a></li>

                        <li><a href="index.php?view=placa_fabrica&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa  fa-steam" style="color: orange;"></i> Placas</a></li>
                      </ul>
                    </li>





                    <li class="header"><i class="fa fa-windows" style="color: orange;"></i> CAJA</li>
                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-cube" style="color: yellow;"></i> <span> CAJA</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">


                        <li><a
                            href="index.php?view=cajausuario&id_sucursal=<?php echo $sucursal->id_sucursal; ?>&id_usuario=<?php echo $u->id_usuario; ?>"><i
                              class="fa fa-cart-plus" style="color: orange;"></i>Iniciar Caja</a></li>
                      </ul>
                    </li>
                    <li class="header"><i class="fa fa-image" style="color: orange;"></i> REPORTE EN GENERAL</li>
                    <li class="treeview">
                      <a href="#">
                        <i class="fa  fa-line-chart" style="color: yellow;"></i> <span> REPORTES</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="index.php?view=libroop&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte entradas y salidas </a></li>

                        <li><a href="index.php?view=libroventag&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte Ventas Electronicas</a></li>


                        <?php if ($u->opciones == 1) { ?>
                          <li><a href="index.php?view=libroestadocobros&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                                class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte Cobranzas </a></li>
                        <?php } ?>

                        <li><a href="index.php?view=reportestockproductos&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte Stock de Productos</a></i></li>

                        <li><a href="index.php?view=reporteresolucion&id_sucursal=<?php echo $sucursal->id_sucursal; ?>"><i
                              class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte Resolución 90</a></i></li>


                        <li>
                          <?php if ($sucursal->tipo_recibo == 0) { ?>
                            <a target="_BLANK" href="http://192.168.30.154:84/importacion_mercury/"><i class="fa fa-bar-chart-o"
                                style="color: orange;"></i>Exportar Ventas Electrónicas</a>
                          <?php }
                          if ($sucursal->tipo_recibo == 1) { ?>
                            <a target="_BLANK" href="http://192.168.30.154:84/importacion_bravo/"><i class="fa fa-bar-chart-o"
                                style="color: orange;"></i>Exportar Ventas Electrónicas</a>

                          <?php } ?>
                        </li>

                      </ul>
                    </li>
                  </ul>

                <?php endforeach ?>
              <?php endif ?>



            <?php } ?>



            <!-- FIN DEL MENU -->

          </section>



        <?php endif; ?>
        <!-- /.sidebar -->
      </aside>
      <div>
        <?php
        if (isset($_SESSION["admin_id"])) {
          View::load("index");
        } else {
          Action::execute2("login", array());
        } ?>
      </div>
      <?php if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""): ?>
        <?php
        $u = null;
        if ($_SESSION["admin_id"] != "") {
          $u = UserData::getById($_SESSION["admin_id"]);
        } ?>

        <footer class="main-footer">
          <div class="pull-right hidden-xs">
            Copyright &copy; 2023 <a href="https://rconsultores.com.py" target="_blank"> <b>Desarrollado por
                Syscomdl</b></a>
            <b>Version</b> 1.4




          </div>
          <strong>
            <h1> </h1>
          </strong>
        </footer>
      <?php else: ?>
      <?php endif; ?>

    </div>




</body>

</html>
<div class="modal fade" id="profile">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Perfil Administrador</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="index.php?action=editarusuario"
          enctype="multipart/form-data">
          <div class="form-group">
            <label for="firstname" class="col-sm-3 control-label">Nombre</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $u->nombre; ?>"
                disabled="">
            </div>
          </div>
          <div class="form-group">
            <label for="lastname" class="col-sm-3 control-label">Apellido</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $u->apellido; ?>"
                disabled="">
            </div>
          </div>
          <div class="form-group">
            <label for="photo" class="col-sm-3 control-label">Foto:</label>

            <div class="col-sm-9">
              <input type="file" id="image" name="image">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail1" class="col-lg-3 control-label">Esta activo</label>
            <div class="col-md-9">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="is_active" <?php if ($u->is_active) {
                    echo "checked";
                  } ?> disabled="">
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail1" class="col-lg-3 control-label">Es administrador</label>
            <div class="col-md-9">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="is_admin" <?php if ($u->is_admin) {
                    echo "checked";
                  } ?> disabled="">
                </label>
              </div>
            </div>
          </div>
          <hr>
          <div class="form-group">
            <label for="username" class="col-sm-3 control-label">Usuario</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="username" name="username" value="<?php echo $u->username; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail1" class="col-lg-3 control-label">Nueva Contrase&ntilde;a</label>
            <div class="col-md-8">
              <input type="password" name="password" class="form-control" id="inputEmail1"
                placeholder="Contrase&ntilde;a">
              <p class="help-block">La contrase&ntilde;a solo se modificara si escribes algo, en caso contrario no se
                modifica.</p>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
            class="fa fa-close"></i> Cerrar</button>
        <button type="submit" class="btn btn-success btn-flat" name="save"><i class="fa fa-check-square-o"></i>
          Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg" id="perfil">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><label>
            <marquee> DATOS DEL ADMINISTRADOR</marquee>
          </label></h4>
      </div>
      <div class="modal-body">
        <div class="contendor_kn">
          <div class="panel panel-default">
            <div class="panel-body">
              <form method="POST" id="update-form-administrador">
                <div class="col-md-6">
                  <input type="text" id="personal_id" name="personal_id" hidden value="<?php echo $u->nombre; ?>">
                  <label class="col-sm-4 control-label">Nombres </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)"
                      name="nombres_personal" id="nombres_personal" placeholder="Ingrese Nombres" maxlength=""
                      value="<?php echo $u->nombre; ?>" disabled="">
                    <br>
                  </div>
                  <label class="col-sm-4 control-label">Apellidos</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)"
                      name="apePate_personal" id="apePate_personal" placeholder="Ingrese Apellido Paterno" maxlength=""
                      value="<?php echo $u->apellido; ?>" disabled="">
                    <br>
                  </div>
                  <label class="col-sm-4 control-label">Apellido Materno </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)"
                      name="apeMate_personal" id="apeMate_personal" placeholder="Ingrese Apelido Materno" maxlength=""
                      disabled="">
                    <br>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="col-sm-12" style="text-align:center">
                    <label class="control-label">Fotograf&iacute;a</label><br>
                    <div id="txtimagen2">
                      <?php if ($u->imagen != ""): ?>
                        <img src="storage/usuario/<?php echo $u->imagen; ?>" class="img-circle" alt="User Image"
                          style="width:90px;">
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <label class="col-sm-2 control-label">Email </label>
                  <div class="col-sm-4">
                    <input type="email" class="form-control" style="width: 94%" name="email_personal"
                      id="email_personal" placeholder="Ingrese email" maxlength="100" value="<?php echo $u->email; ?>"
                      disabled="">
                    <br>
                  </div>
                  <label class="col-sm-2 control-label">Tel&eacute;fono </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" onkeypress="return soloNumeros(event)"
                      name="telefono_personal" id="telefono_personal" placeholder="Ingrese nro telefóno" maxlength="9"
                      value="910122259" disabled="">
                    <br>
                  </div>

                  <label class="col-sm-2 control-label">Movil </label>
                  <div class="col-sm-4">
                    <input type="text" style="width: 94%" class="form-control" name="movil_personal" id="movil_personal"
                      onkeypress="return soloNumeros(event)" placeholder="Ingrese nro movil" maxlength="9"
                      value="910122259" disabled="">
                    <br>
                  </div>
                  <label class="col-sm-2 control-label">Direcci&oacute;n </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" onkeypress="return soloLetras(event)"
                      name="direccion_personal" id="direccion_personal" placeholder="Ingrese dirección" maxlength="200"
                      value="av. peru" disabled="">
                    <br>
                  </div>
                  <label class="col-sm-2 control-label">Fecha de Registro </label>
                  <div class="col-sm-4">
                    <div class=" input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" style="width: 94%;padding: 0px 12px;" id="fechanacimiento_personal"
                        name="fechanacimiento_personal" class="form-control" disabled=""
                        value="<?php echo $u->fecha; ?>">
                    </div>
                  </div>
                  <label class="col-sm-2 control-label">DNI </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" onkeypress="return soloNumeros(event)" name="dni_personal"
                      id="dni_personal" placeholder="Ingrese DNI" maxlength="13" value="70933255" disabled="">
                    <br>
                  </div>
                  <label class="col-sm-2 control-label">Es Administrador </label>
                  <div class="col-sm-4">
                    <label>
                      <input type="checkbox" name="is_admin" <?php if ($u->is_admin) {
                        echo "checked";
                      } ?>>
                    </label>
                    <br>
                  </div>
                  <label class="col-sm-2 control-label">Esta Activo </label>
                  <div class="col-sm-4">
                    <label>
                      <input type="checkbox" name="is_active" <?php if ($u->is_active) {
                        echo "checked";
                      } ?>>
                    </label>
                    <br>
                  </div>


                </div>
                <div class="col-md-12 col-lg-12 col-xs-12" style="text-align:center;">
                  <br>
                  <div class="col-md-4">
                  </div>

                  <div class="col-md-4">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><i class="fa fa-close"></i><strong>
            Close</strong></button>
      </div>
    </div>
  </div>

  <script>
    $('#togglebutton').click(function () { //replace the id with the toggle button id
      if (clickCount % 2 == 0) {
        openNav();
      } else {
        closeNav();
      }
      clickCount++;
    });
    // console.log('wewqew', );
    setTimeout(
      function a() {
        $('push-menu').toggle();
      }

      , 3000);

  </script>



  <script>
    function iniciarControlInactividad() {
      let timerInactividad;
      let timerRedireccion;

      function reiniciarTemporizador() {
        clearTimeout(timerInactividad);
        timerInactividad = setTimeout(() => {
          mostrarAlertaSesionFinalizada();
        }, 120000); // 2 minutos
      }

      function mostrarAlertaSesionFinalizada() {
        // Swal.fire({
        //   title: '¿Desea continuar en el sistema?',
        //   text: 'Su sesión será cerrada en 20 segundos por inactividad.',
        //   icon: 'warning',
        //   showConfirmButton: true,
        //   confirmButtonText: 'Continuar en el sistema',
        //   allowOutsideClick: false,
        //   allowEscapeKey: false,
        //   timerProgressBar: true,
        //   didOpen: () => {
        //     // Redirección automática en 20 segundos si no se responde
        //     timerRedireccion = setTimeout(() => {
        //       Swal.close();
        //       window.location.href = 'salir.php';
        //     }, 20000); // 20 segundos
        //   },
        //   willClose: () => {
        //     clearTimeout(timerRedireccion);
        //   }
        // }).then((result) => {
        //   if (result.isConfirmed) {
        //     reiniciarTemporizador(); // Continúa trabajando
        //     Swal.fire('¡Bienvenido de nuevo!', '', 'success');
        //   }
        // });
      }

      // Eventos que reinician el temporizador de inactividad
      ['load', 'mousemove', 'keypress', 'click', 'scroll'].forEach(evt => {
        window.addEventListener(evt, reiniciarTemporizador);
      });

      // reiniciarTemporizador(); // iniciar al cargar
    }

    iniciarControlInactividad();
  </script>