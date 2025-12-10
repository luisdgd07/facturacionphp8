<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📄</text></svg>">
    <?php
    $config = ConfigData::getAll();
    if (count($config) > 0) {
        foreach ($config as $configuracion) { ?>
            <title><?php echo $configuracion->texto1; ?></title>
            <?php
        }
    }
    ?>
    <script src="plugins/jquery/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="res/dist/css/AdminLTE.min.css">
    <!-- <link rel="stylesheet" href="res/javi/personalizacion.css"> -->
    <link rel="stylesheet" href="res/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="res/bower_components/Ionicons/css/ionicons.min.css"> -->
    <link rel="stylesheet" href="res/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="res/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="res/bower_components/morris.js/morris.css"> -->


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
                <!-- Header -->
                <?php include __DIR__ . '/components/header.php'; ?>

                <!-- Left side column. contains the logo and sidebar -->
                <aside class="main-sidebar">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                        <!-- Sidebar user panel -->
                        <?php include __DIR__ . '/components/sidebar-user-panel.php'; ?>

                        <!-- Menú de Administrador -->
                        <?php if ($u->is_admin): ?>
                            <?php include __DIR__ . '/components/menu-admin.php'; ?>
                        <?php endif; ?>

                        <!-- Menú de Sucursales -->
                        <?php
                        // Incluir helper de menús
                        require_once __DIR__ . '/helpers/menu-helper.php';

                        // Obtener sucursales del usuario
                        $sucursales = getUserSucursales($u);

                        if (count($sucursales) > 0):
                            foreach ($sucursales as $sucur):
                                $sucursal = $sucur->verSocursal();
                                // Renderizar menú de sucursal
                                renderSucursalMenu($sucursal, $u);
                            endforeach;
                        endif;
                        ?>

                        <!-- FIN DEL MENU -->
                    </section>
                </aside>

                <!-- Content Wrapper -->
                <div>
                    <?php
                    if (isset($_SESSION["admin_id"])) {
                        View::load("index");
                    } else {
                        Action::execute2("login", array());
                    }
                    ?>
                </div>

                <!-- Footer -->
                <?php if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""): ?>
                    <?php include __DIR__ . '/components/footer.php'; ?>
                <?php endif; ?>

            </div>

        <?php else: ?>
            <!-- Login page content -->
            <?php
            if (isset($_SESSION["admin_id"])) {
                View::load("index");
            } else {
                Action::execute2("login", array());
            }
            ?>
        <?php endif; ?>

    </div>

    <!-- Modales -->
    <?php if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != ""): ?>
        <?php
        $u = null;
        if ($_SESSION["admin_id"] != "") {
            $u = UserData::getById($_SESSION["admin_id"]);
        }
        include __DIR__ . '/components/modals.php';
        ?>
    <?php endif; ?>

    <!-- Scripts -->
    <script src="res/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="res/dist/js/adminlte.min.js"></script>

    <script>
        var clickCount = 0;

        $('#togglebutton').click(function () {
            if (clickCount % 2 == 0) {
                openNav();
            } else {
                closeNav();
            }
            clickCount++;
        });

        setTimeout(function a() {
            $('push-menu').toggle();
        }, 3000);
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
                // Código comentado para control de sesión
                // Se puede activar según necesidad
            }

            // Eventos que reinician el temporizador de inactividad
            ['load', 'mousemove', 'keypress', 'click', 'scroll'].forEach(evt => {
                window.addEventListener(evt, reiniciarTemporizador);
            });
        }

        iniciarControlInactividad();
    </script>

</body>

</html>