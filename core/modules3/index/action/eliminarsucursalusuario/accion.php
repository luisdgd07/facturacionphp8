<?php
$client = SucursalUusarioData::VerId($_GET["id_sucursalusuario"]);
$client->eliminar();
Core::redir("index.php?view=administrador");

?>