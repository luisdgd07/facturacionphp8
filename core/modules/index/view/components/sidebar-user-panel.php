<?php
/**
 * Sidebar User Panel Component
 * Panel de usuario en la barra lateral
 */
?>
<div class="user-panel">
    <div class="pull-left image">
        <?php
        $config = ConfigData::getAll();
        if (count($config) > 0) {
            foreach ($config as $configuracion) {
                $url = "storage/sis/admin/" . $configuracion->logo;
                ?>
                <?php if ($configuracion->logo != "" && file_exists($url)): ?>
                    <img src="<?php echo $url; ?>" class="img-circle" alt="User Image">
                <?php endif; ?>
                <?php
            }
        }
        ?>
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