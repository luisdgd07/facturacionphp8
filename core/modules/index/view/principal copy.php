<?php
// Configuración inicial
$config = ConfigData::getAll();
$configuracion = $config[0] ?? null;
$timezone = 'America/Bogota';
date_default_timezone_set($timezone);

// Variables de sesión
$u = null;
$isLoggedIn = isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "";
if ($isLoggedIn) {
    $u = UserData::getById($_SESSION["admin_id"]);
    $url = "storage/admin/" . $u->imagen;
}

// Función para generar enlaces del menú
function generateMenuLink($view, $id_sucursal, $icon, $text, $badge = null) {
    $link = "index.php?view={$view}&id_sucursal={$id_sucursal}";
    $badgeHtml = $badge ? "<span class=\"pull-right-container\"><small class=\"label pull-right bg-yellow\">{$badge}</small></span>" : "";
    
    return "<li class=\"active\">
        <a href=\"{$link}\">
            <i class=\"fa {$icon}\" style=\"color: yellow;\"></i> 
            <span>{$text}</span>
            {$badgeHtml}
        </a>
    </li>";
}

// Función para generar submenús
function generateSubmenu($title, $icon, $items) {
    $html = "<li class=\"treeview\">
        <a href=\"#\">
            <i class=\"fa {$icon}\" style=\"color: yellow;\"></i> 
            <span> {$title}</span>
            <span class=\"pull-right-container\">
                <i class=\"fa fa-angle-left pull-right\"></i>
            </span>
        </a>
        <ul class=\"treeview-menu\">";
    
    foreach ($items as $item) {
        $html .= "<li><a href=\"{$item['link']}\"><i class=\"fa {$item['icon']}\" style=\"color: orange;\"></i> {$item['text']}</a></li>";
    }
    
    $html .= "</ul></li>";
    return $html;
}

// Función para generar menús de sucursal
function generateSucursalMenu($sucursal, $u) {
    $menuItems = [
        'CLIENTES' => [
            'icon' => 'fa-shopping-cart',
            'items' => [
                ['link' => "index.php?view=cliente&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-user', 'text' => 'Clientes'],
                ['link' => "index.php?view=estadodecuenta&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-money', 'text' => 'Estado de cuenta general'],
                ['link' => "index.php?view=libroestado&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-money', 'text' => 'Estado de cuenta detallado'],
                ['link' => "index.php?view=nuevocontrato&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-money', 'text' => 'Nuevo Contrato'],
                ['link' => "index.php?view=contratos&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-money', 'text' => 'Contratos'],
                ['link' => "index.php?view=listadocontratoscliente2&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-money', 'text' => 'Listado conceptos por Contratos'],
                ['link' => "index.php?view=listadocontratoscliente&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-money', 'text' => 'Listado conceptos por clientes']
            ]
        ],
        'REMISION' => [
            'icon' => 'fa-shopping-cart',
            'items' => [
                ['link' => "index.php?view=remision&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-money', 'text' => 'Realizar Remisión'],
                ['link' => "index.php?view=remision1&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-money', 'text' => 'Remisiones pendientes'],
                ['link' => "index.php?view=listadoplacas&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cart-plus', 'text' => 'Listado de Placas'],
                ['link' => "index.php?view=remision2&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-money', 'text' => 'Remisiones'],
                ['link' => "index.php?view=envioremision&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-money', 'text' => 'Envio de Remisión'],
                ['link' => "index.php?view=envioventaremision&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-money', 'text' => 'Envio de Venta c/ Remisión']
            ]
        ],
        'VENTAS' => [
            'icon' => 'fa-shopping-cart',
            'items' => [
                ['link' => "index.php?view=vender&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-money', 'text' => 'Realizar Venta'],
                ['link' => "index.php?view=ventas&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cart-plus', 'text' => 'Ventas'],
                ['link' => "index.php?view=vender2&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-money', 'text' => 'Realizar Venta Contrato'],
                ['link' => "index.php?view=masiva&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cart-plus', 'text' => 'Ventas Masivas'],
                ['link' => "index.php?view=ventas-masiva-detalle&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cart-plus', 'text' => 'Detalles Ventas Masivas'],
                ['link' => "index.php?view=envioporlote&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cart-plus', 'text' => 'Envios a SIFEN'],
                ['link' => "index.php?view=cobrocaja&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cart-plus', 'text' => 'Cobro Caja'],
                ['link' => "index.php?view=cobros&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cart-plus', 'text' => 'Cobros'],
                ['link' => "index.php?view=listacredito&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cart-plus', 'text' => 'Credito Clientes'],
                ['link' => "index.php?view=tarjeta&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cart-plus', 'text' => 'Tarjeta'],
                ['link' => "index.php?view=retencion&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cart-plus', 'text' => 'Retención'],
                ['link' => "index.php?view=cuentabancaria&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cart-plus', 'text' => 'Movimiento Bancario']
            ]
        ],
        'NOTA DE CREDITO' => [
            'icon' => 'fa-shopping-cart',
            'items' => [
                ['link' => "index.php?view=nota_de_credito&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cart-plus', 'text' => 'Notas de Credito'],
                ['link' => "index.php?view=envionotacredito&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cart-plus', 'text' => 'Envios a SIFEN']
            ]
        ],
        'PRODUCTOS' => [
            'icon' => 'fa-android',
            'items' => [
                ['link' => "index.php?view=nuevoproducto1&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-laptop', 'text' => 'Nuevo producto'],
                ['link' => "index.php?view=producto&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-laptop', 'text' => 'Lista de Productos'],
                ['link' => "index.php?view=categoria&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-steam', 'text' => 'Categoria'],
                ['link' => "index.php?view=marca&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-steam', 'text' => 'Marca'],
                ['link' => "index.php?view=grupos&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-steam', 'text' => 'Grupos']
            ]
        ],
        'INVENTARIO' => [
            'icon' => 'fa-building-o',
            'items' => [
                ['link' => "index.php?view=inventario&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-heartbeat', 'text' => 'Stock de Productos'],
                ['link' => "index.php?view=transacciones&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cogs', 'text' => 'Movimiento de Stock'],
                ['link' => "index.php?view=transa&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cogs', 'text' => 'Transacciones'],
                ['link' => "index.php?view=transacioness&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cogs', 'text' => 'Transacciones por producto']
            ]
        ],
        'CONFIGURACIONES' => [
            'icon' => 'fa-building-o',
            'items' => [
                ['link' => "index.php?view=moneda&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cogs', 'text' => 'Moneda'],
                ['link' => "index.php?view=cotizacion&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cogs', 'text' => 'Cotización'],
                ['link' => "index.php?view=cofigfactura&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cogs', 'text' => 'Config. Factura'],
                ['link' => "index.php?view=configmasiva&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cogs', 'text' => 'Config. Masiva'],
                ['link' => "index.php?view=tipo_producto&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cogs', 'text' => 'Tipo Producto'],
                ['link' => "index.php?view=deposito&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cogs', 'text' => 'Depósito'],
                ['link' => "index.php?view=lista_precio&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cogs', 'text' => 'Lista de Precios'],
                ['link' => "index.php?view=producto_precio&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cogs', 'text' => 'Precio de Productos'],
                ['link' => "index.php?view=choferes&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cogs', 'text' => 'Choferes'],
                ['link' => "index.php?view=vended&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cogs', 'text' => 'Vendedor'],
                ['link' => "index.php?view=vehiculos&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-cogs', 'text' => 'Vehiculos'],
                ['link' => "index.php?view=placa_fabrica&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-steam', 'text' => 'Placas']
            ]
        ],
        'CAJA' => [
            'icon' => 'fa-cube',
            'items' => [
                ['link' => "index.php?view=cajausuario&id_sucursal={$sucursal->id_sucursal}&id_usuario={$u->id_usuario}", 'icon' => 'fa-cart-plus', 'text' => 'Iniciar Caja']
            ]
        ],
        'REPORTES' => [
            'icon' => 'fa-line-chart',
            'items' => [
                ['link' => "index.php?view=libroop&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-bar-chart-o', 'text' => 'Reporte entradas y salidas'],
                ['link' => "index.php?view=libroventag&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-bar-chart-o', 'text' => 'Reporte Ventas Electronicas'],
                ['link' => "index.php?view=libroestadocobros&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-bar-chart-o', 'text' => 'Reporte Cobranzas'],
                ['link' => "index.php?view=reportestockproductos&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-bar-chart-o', 'text' => 'Reporte Stock de Productos'],
                ['link' => "index.php?view=reporteresolucion&id_sucursal={$sucursal->id_sucursal}", 'icon' => 'fa-bar-chart-o', 'text' => 'Reporte Resolución 90']
            ]
        ]
    ];

    $html = "<ul class=\"sidebar-menu\" data-widget=\"tree\">
        <li class=\"header\" style=\"font-size: 15px; margin: auto; text-align: center; color: #FFA200; border: 7px solid #FF0000;\"><i></i>{$sucursal->nombre}</li>";
    
    // Enlaces principales
    $html .= generateMenuLink('remision', $sucursal->id_sucursal, 'fa-money', 'REALIZAR REMISION', 'REMISION');
    $html .= generateMenuLink('remision1', $sucursal->id_sucursal, 'fa-laptop', 'REMISIONES PENDIENTES', 'PENDIENTES');
    $html .= generateMenuLink('envioventaremision', $sucursal->id_sucursal, 'fa-laptop', 'ENVIAR VENTA C/ REMISION', 'ENVIAR VENTA C/ REMISION');
    
    // Generar submenús
    foreach ($menuItems as $title => $menu) {
        if ($title === 'REPORTES' && $u->opciones != 1) {
            // Filtrar reportes según permisos
            $filteredItems = array_filter($menu['items'], function($item) {
                return strpos($item['text'], 'Cobranzas') === false;
            });
            $menu['items'] = $filteredItems;
        }
        
        $html .= generateSubmenu($title, $menu['icon'], $menu['items']);
    }
    
    // Enlace de exportación según tipo de recibo
    $exportUrl = $sucursal->tipo_recibo == 0 
        ? "http://192.168.30.154:84/importacion_mercury/"
        : "http://192.168.30.154:84/importacion_bravo/";
    
    $html .= "<li><a target=\"_BLANK\" href=\"{$exportUrl}\"><i class=\"fa fa-bar-chart-o\" style=\"color: orange;\"></i>Exportar Ventas Electrónicas</a></li>";
    
    $html .= "</ul>";
    
    return $html;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $configuracion ? $configuracion->texto1 : 'Sistema de Facturación'; ?></title>
    <link rel="icon" type="icon" href="storage/iconos/7.png">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="res/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="res/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="res/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="res/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="res/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="res/bower_components/morris.js/morris.css">
    <link rel="stylesheet" href="res/bower_components/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="res/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="res/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="res/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="res/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="res/plugins/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="res/bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="res/plugins/iCheck/square/blue.css">
    <link rel="stylesheet" href="res/plugins/iCheck/all.css">
    <link rel="stylesheet" href="res/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="res/javi/personalizacion.css">
    
    <style>
        #mostrar, #ocultar, #mostrar1, #ocultar1 { display: none; }
        .mt20 { margin-top: 20px; }
        .bold { font-weight: bold; }
        
        #legend ul {
            list-style: none;
        }
        #legend ul li {
            display: inline;
            padding-left: 30px;
            position: relative;
            margin-bottom: 4px;
            border-radius: 5px;
            padding: 2px 8px 2px 28px;
            font-size: 14px;
            cursor: default;
            transition: background-color 200ms ease-in-out;
        }
        #legend li span {
            display: block;
            position: absolute;
            left: 0;
            top: 0;
            width: 20px;
            height: 100%;
            border-radius: 5px;
        }
        
        .img-responsive {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body class="<?php echo $isLoggedIn ? 'hold-transition skin-blue sidebar-collapse' : 'login-page'; ?>" oncopy="return true" onpaste="return true">
    <div class="wrapper">
        <?php if ($isLoggedIn): ?>
            <header class="main-header">
                <a href="./" class="logo">
                    <span class="logo-mini"><b>R</b>&C</span>
                    <span class="logo-lg"><b><?php echo $configuracion ? $configuracion->nombre : 'Sistema'; ?></b></span>
                </a>
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php if ($u->imagen && file_exists($url)): ?>
                                        <img src="<?php echo $url; ?>" class="user-image" alt="User Image">
                                    <?php endif; ?>
                                    <span class="hidden-xs"><?php echo $u->nombre . " " . $u->apellido; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <?php if ($u->imagen && file_exists($url)): ?>
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

            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <?php if ($configuracion && $configuracion->logo): ?>
                                <?php 
                                $logoUrl = "storage/sis/admin/" . $configuracion->logo;
                                if (file_exists($logoUrl)): 
                                ?>
                                    <img src="<?php echo $logoUrl; ?>" class="img-circle" alt="User Image">
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $u->nombre . " " . $u->apellido; ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>

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
                                    <li><a href="index.php?view=administrador"><i class="fa fa-user-secret" style="color: orange;"></i> Usuarios</a></li>
                                </ul>
                            </li>

                            <li class="header"><i class="fa fa-image" style="color: orange;"></i> REPORTE EN GENERAL</li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-line-chart" style="color: yellow;"></i> <span> REPORTES</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?view=reporte_venta_general"><i class="fa fa-bar-chart-o" style="color: orange;"></i> Reporte Ventas por Empresa</a></li>
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
                                    <li><a href="index.php?view=config"><i class="fa fa-gear" style="color: orange;"></i> Configuración</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php endif; ?>

                    <?php
                    $usuarioss = UserData::getById($u->id_usuario);
                    $sucursales = SucursalUusarioData::verusucursalusuarios($usuarioss->id_usuario);
                    
                    if (count($sucursales) > 0):
                        foreach ($sucursales as $sucur):
                            $sucursal = $sucur->verSocursal();
                            echo generateSucursalMenu($sucursal, $u);
                        endforeach;
                    endif;
                    ?>
                </section>
            </aside>

            <div>
                <?php
                if (isset($_SESSION["admin_id"])) {
                    View::load("index");
                } else {
                    Action::execute("login", array());
                }
                ?>
            </div>

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    Copyright &copy; 2023 <a href="https://rconsultores.com.py" target="_blank"> <b>Desarrollado por Syscomdl</b></a>
                    <b>Version</b> 1.4
                </div>
                <strong><h1></h1></strong>
            </footer>
        <?php endif; ?>
    </div>

    <!-- Scripts -->
    <script src="plugins/jquery/jquery-2.1.4.min.js"></script>
    <script src="res/javi/JsBarcode.all.min.js"></script>
    <script src="res/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="res/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="res/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="res/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="res/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="res/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="res/bower_components/moment/min/moment.min.js"></script>
    <script src="res/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="res/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="res/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <script src="res/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="res/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script src="res/bower_components/raphael/raphael.min.js"></script>
    <script src="res/bower_components/morris.js/morris.min.js"></script>
    <script src="res/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <script src="res/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="res/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="res/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
    <script src="res/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="res/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script src="res/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="res/dist/js/adminlte.min.js"></script>
    <script src="res/dist/js/pages/dashboard.js"></script>
    <script src="res/dist/js/demo.js"></script>
    <script src="res/bower_components/chart.js/Chart.js"></script>
    <script src="res/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="res/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="res/javi/operacion.js"></script>
    <script src="res/javi/personalizacion.js"></script>
    <script src="res/plugins/iCheck/icheck.min.js"></script>

    <script>
        $(function() {
            // Initialize Select2 Elements
            $('.select2').select2();

            // Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
            $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'});
            
            // Money Euro
            $('[data-mask]').inputmask();

            // Date range picker
            $('#reservation').daterangepicker();
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: { format: 'MM/DD/YYYY hh:mm A' }
            });
            $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            }, function(start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });

            // Date picker
            $('#datepicker').datepicker({ autoclose: true });

            // iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            });
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });

            // Colorpicker
            $('.my-colorpicker1, .my-colorpicker2').colorpicker();

            // Timepicker
            $('.timepicker').timepicker({ showInputs: false });

            // DataTables
            $('#example1').DataTable();
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            });
        });

        // Funciones de búsqueda unificadas
        function initializeSearch(formId, resultId, action, inputId) {
            $(document).ready(function() {
                $(formId).on("submit", function(e) {
                    e.preventDefault();
                    $.get("./?action=" + action, $(formId).serialize(), function(data) {
                        $(resultId).html(data);
                    });
                    $(inputId).val("");
                });

                $(inputId).keydown(function(e) {
                    if (e.which == 17 || e.which == 74) {
                        e.preventDefault();
                    }
                });
            });
        }

        // Inicializar todas las búsquedas
        initializeSearch("#searchppp", "#resultado_producto", "buscarproducto", "#javier");
        initializeSearch("#buscador", "#resultadosbuscador", "buscarproducto1", "#javier");
        initializeSearch("#transaccioness", "#resultado_productos", "buscarproductos", "#caja");
        initializeSearch("#searchpppp", "#resultado_postre", "buscarpostre", "#nombree");

        // Funciones de mostrar/ocultar
        function Mostrar() {
            document.getElementById('mostrar').style.display = 'block';
            document.getElementById('ocultar').style.display = 'none';
        }

        function Ocultar() {
            document.getElementById('mostrar').style.display = 'none';
            document.getElementById('ocultar').style.display = 'block';
        }

        function Mostrar1() {
            document.getElementById('mostrar1').style.display = 'block';
            document.getElementById('ocultar1').style.display = 'none';
        }

        function Ocultar1() {
            document.getElementById('mostrar1').style.display = 'none';
            document.getElementById('ocultar1').style.display = 'block';
        }

        // Validación de contraseña
        $("#changepasswd").submit(function(e) {
            if ($("#password").val() == "" || $("#newpassword").val() == "" || $("#confirmnewpassword").val() == "") {
                e.preventDefault();
                alert("No debes dejar espacios vacios.");
            } else if ($("#newpassword").val() != $("#confirmnewpassword").val()) {
                e.preventDefault();
                alert("Las nueva contraseña no coincide con la confirmacion.");
            }
        });

        // Control de inactividad
        function iniciarControlInactividad() {
            let timerInactividad;
            let timerRedireccion;

            function reiniciarTemporizador() {
                clearTimeout(timerInactividad);
                timerInactividad = setTimeout(() => {
                    // Función de alerta comentada por ahora
                }, 120000);
            }

            ['load', 'mousemove', 'keypress', 'click', 'scroll'].forEach(evt => {
                window.addEventListener(evt, reiniciarTemporizador);
            });
        }

        // iniciarControlInactividad();

        // Barcode
        JsBarcode("#barcoder", "1234", {
            format: "pharmacode",
            lineColor: "#000",
            width: 4,
            height: 40,
            displayValue: false
        });
    </script>

    <!-- Modales -->
    <?php if ($isLoggedIn): ?>
        <!-- Modal de Perfil -->
        <div class="modal fade" id="profile">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"><b>Perfil Administrador</b></h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="POST" action="index.php?action=editarusuario" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="firstname" class="col-sm-3 control-label">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $u->nombre; ?>" disabled="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="col-sm-3 control-label">Apellido</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $u->apellido; ?>" disabled="">
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
                                            <input type="checkbox" name="is_active" <?php echo $u->is_active ? "checked" : ""; ?> disabled="">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 control-label">Es administrador</label>
                                <div class="col-md-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="is_admin" <?php echo $u->is_admin ? "checked" : ""; ?> disabled="">
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
                                <label for="inputEmail1" class="col-lg-3 control-label">Nueva Contraseña</label>
                                <div class="col-md-8">
                                    <input type="password" name="password" class="form-control" id="inputEmail1" placeholder="Contraseña">
                                    <p class="help-block">La contraseña solo se modificará si escribes algo, en caso contrario no se modifica.</p>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                        <button type="submit" class="btn btn-success btn-flat" name="save"><i class="fa fa-check-square-o"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>