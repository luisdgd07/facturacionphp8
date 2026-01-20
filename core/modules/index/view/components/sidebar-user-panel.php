<?php
/**
 * Sidebar User Panel Component
 * Panel de usuario en la barra lateral
 */
?>
<div class="user-panel modern-user-panel">
    <div class="image-container">
        <?php
        $config = ConfigData::getAll();
        if (count($config) > 0) {
            foreach ($config as $configuracion) {
                $url = "storage/sis/admin/" . $configuracion->logo;
                ?>
                <?php if ($configuracion->logo != "" && file_exists($url)): ?>
                    <img src="<?php echo $url; ?>" class="img-circle modern-sidebar-logo" alt="System Logo">
                <?php else: ?>

                <?php endif; ?>
                <?php
            }
        }
        ?>

        <style>
            .mod ern-user-panel {
                display: flex;
                align-items: center;

                padding: 20px 15px;
                background: rgba(0, 0, 0, 0.1);
                margin-bottom: 10px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }

            .modern-user-panel .image-container {
                flex-shrink: 0;
                margin-right: 15px;
            }

            .modern-sidebar-logo {
                width: 45px;
                height: 45px;
                border: 2px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
                transition: transform 0.3s ease;
            }

            .modern-user-panel:hover .modern-sidebar-logo {
                transform: scale(1.05);
                border-color: #fff;
            }

            .fallback-logo {
                width: 45px;
                height: 45px;
                border-radius: 50%;
                background: #444;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #aaa;
                border: 2px solid rgba(255, 255, 255, 0.1);
            }

            .modern-user-panel .info-container {
                overflow: hidden;
            }

            .mod ern-user-panel .user-name {
                font-weight: 600;
                color: #fff;
                margin-bottom: 5px;
                font-size: 14px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            }

            .mod ern-user-panel .user-status {
                color: #b8c7ce;
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                display: flex;
                align-items: center;
                text-decoration: none;
            }

            .modern-user-panel .user-status i {
                margin-right: 5px;
                font-size: 10px;
            }

            /* P ulsa
    t           ing online dot */


            @key frame s pulsate {


                0% {
                    b o x-shadow: 0 0 0 0 rgba(0, 255, 0, 0.4);
                }

                70% {
                    box-shadow: 0 0 0 6px rgba(0, 255, 0, 0);
                }

                100% {
                    box-shadow: 0 0 0 0 rgba(0, 255, 0, 0);
                }
            }

            .pul sate {
                animation: pulsate 2s infinite;
                border-radius: 50%;
            }
        </style>