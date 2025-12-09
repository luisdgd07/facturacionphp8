<?php
/**
 * Header Component
 * Componente del encabezado principal del sistema
 */
?>
<header class="main-header">
    <a href="./" class="logo">
        <span class="logo-mini"><b>R</b>&C</span>
        <?php
        $config = ConfigData::getAll();
        if (count($config) > 0) {
            foreach ($config as $configuracion) { ?>
                <span class="logo-lg"><b><?php echo $configuracion->nombre; ?></b></span>
                <?php
            }
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