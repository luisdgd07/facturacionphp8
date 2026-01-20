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
                <span class="logo-lg" style="font-size: 18px;"><b><?php echo $configuracion->nombre; ?></b></span>
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
                <li class="dropdown user user-menu modern-user-menu">
                    <a href="#" class="dropdown-toggle user-dropdown-toggle" data-toggle="dropdown">
                        <div class="user-avatar-wrapper">
                            <?php if ($u->imagen != "" && file_exists($url)): ?>
                                <img src="<?php echo $url; ?>" class="user-image modern-avatar"
                                    alt="<?php echo $u->nombre; ?>">
                            <?php else: ?>
                                <div class="user-image-fallback">
                                    <span class="user-initials">
                                        <?php
                                        echo strtoupper(substr($u->nombre, 0, 1) . substr($u->apellido, 0, 1));
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <span class="hidden-xs user-name-text">
                            <?php echo $u->nombre . " " . $u->apellido; ?>
                            <i class="fa fa-angle-down" style="margin-left: 5px;"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu modern-dropdown">
                        <!-- User image -->
                        <li class="user-header modern-user-header">
                            <div class="user-header-content">
                                <?php if ($u->imagen != "" && file_exists($url)): ?>
                                    <img src="<?php echo $url; ?>" class="img-circle modern-avatar-large"
                                        alt="<?php echo $u->nombre; ?>">
                                <?php else: ?>
                                    <div class="user-image-fallback-large">
                                        <span class="user-initials-large">
                                            <?php
                                            echo strtoupper(substr($u->nombre, 0, 1) . substr($u->apellido, 0, 1));
                                            ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                <p class="user-info-text">
                                    <strong><?php echo $u->nombre . " " . $u->apellido; ?></strong>
                                    <small class="member-since">
                                        <i class="fa fa-calendar"></i> Miembro desde: <?php echo $u->fecha; ?>
                                    </small>
                                </p>
                            </div>
                        </li>
                        <li class="user-footer modern-user-footer">
                            <div class="footer-buttons">
                                <a href="index.php?view=actualizarperfil" class="btn btn-modern btn-profile">
                                    <i class="fa fa-user"></i> Perfil
                                </a>
                                <a href="salir.php" class="btn btn-modern btn-logout">
                                    <i class="fa fa-sign-out"></i> Salir
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <style>
            /* Modern Global Header Styles */
            .main-header {
                max-height: 100px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                position: relative;
                z-index: 1030;
            }

            .main-header .logo {
                background: linear-gradient(to right, #1e2a3a, #2c3e50) !important;
                color: #fff !important;
                border-right: 1px solid rgba(255, 255, 255, 0.05);
                font-family: 'Helvetica Neue', sans-serif;
                height: 56px;
                line-height: 56px;
                font-weight: 700;
                letter-spacing: 1px;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .main-header .navbar {
                background: linear-gradient(90deg, #2c3e50 0%, #4ca1af 100%) !important;
                /* Premium gradient */
                height: 56px;
                border: none;
                margin-left: 230px;
                transition: margin-left .3s ease-in-out;
            }

            /* Sidebar Toggle */
            .main-header .sidebar-toggle {
                color: #fff !important;
                height: 56px;
                line-height: 56px;
                padding: 0 20px !important;
                font-size: 18px;
                transition: background 0.3s;
            }

            .main-header .sidebar-toggle:hover {
                background: rgba(255, 255, 255, 0.1) !important;
            }

            /* Logo Mini & LG adjustment */
            .logo-lg b {
                font-weight: 800;
                background: linear-gradient(to right, #fff, #e0e0e0);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            /* Modern User Menu Styles */
            .modern-user-menu .user-dropdown-toggle {
                display: flex;
                align-items: center;
                padding: 10px 15px;
                height: 56px;
                /* Match navbar height */
                transition: all 0.3s ease;
            }

            .user-name-text {
                color: #fff !important;
                /* Make text white on new dark navbar */
                font-weight: 500;
                font-size: 14px;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            }

            .modern-user-menu .user-dropdown-toggle:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }

            .user-avatar-wrapper {
                margin-right: 10px;
            }

            .modern-avatar {
                width: 35px;
                height: 35px;
                border-radius: 50%;
                border: 2px solid rgba(255, 255, 255, 0.8);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
                transition: transform 0.3s ease;
            }

            .modern-user-menu .user-dropdown-toggle:hover .modern-avatar {
                transform: scale(1.1);
            }

            .user-image-fallback {
                width: 35px;
                height: 35px;
                border-radius: 50%;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                border: 2px solid rgba(255, 255, 255, 0.8);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
                transition: transform 0.3s ease;
            }

            .modern-user-menu .user-dropdown-toggle:hover .user-image-fallback {
                transform: scale(1.1);
            }

            .user-initials {
                color: #fff;
                font-size: 14px;
                font-weight: 600;
                letter-spacing: 0.5px;
            }

            /* Modern Dropdown Styles */
            .modern-dropdown {
                border-radius: 8px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                border: none;
                margin-top: 10px;
                overflow: hidden;
                animation: slideDown 0.3s ease;
                right: 10px;
                /* Slight offset from edge */
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .modern-user-header {
                background: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%);
                /* Match theme */
                padding: 25px 20px;
                text-align: center;
                border: none;
            }

            .user-header-content {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .modern-avatar-large {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                border: 4px solid rgba(255, 255, 255, 0.3);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                margin-bottom: 15px;
            }

            .user-image-fallback-large {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                border: 4px solid rgba(255, 255, 255, 0.3);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                margin-bottom: 15px;
                backdrop-filter: blur(10px);
            }

            .user-initials-large {
                color: #fff;
                font-size: 32px;
                font-weight: 700;
                letter-spacing: 1px;
            }

            .user-info-text {
                color: #fff;
                margin: 0;
            }

            .user-info-text strong {
                font-size: 16px;
                display: block;
                margin-bottom: 8px;
            }

            .member-since {
                display: block;
                font-size: 12px;
                opacity: 0.9;
                margin-top: 5px;
            }

            .member-since i {
                margin-right: 5px;
            }

            /* Modern Footer Styles */
            .modern-user-footer {
                padding: 15px;
                background-color: #f8f9fa;
                border-top: 1px solid #e9ecef;
            }

            .footer-buttons {
                display: flex;
                gap: 10px;
                justify-content: space-between;
            }

            .btn-modern {
                flex: 1;
                padding: 10px 20px;
                border-radius: 6px;
                font-size: 14px;
                font-weight: 500;
                transition: all 0.3s ease;
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .btn-profile {
                background: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%);
                color: #fff;
            }

            .btn-profile:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(76, 161, 175, 0.4);
                color: #fff;
            }

            .btn-logout {
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                color: #fff;
            }

            .btn-logout:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
                color: #fff;
            }

            .btn-modern i {
                font-size: 14px;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .modern-dropdown {
                    min-width: 280px;
                }

                .main-header .logo {
                    width: 100%;
                    float: none;
                }

                .main-header .navbar {
                    width: 100%;
                    float: none;
                    margin: 0;
                }
            }
        </style>
    </nav>
</header>