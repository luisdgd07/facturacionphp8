<?php

$client = ConfigFacturaData::VerId($_GET["id_configfactura"]);
$client->eliminar();
Core::redir("index.php?view=cofigfactura&id_sucursal=".$_GET["id_sucursal"]);
?>