<?php
$client = SuccursalData::VerId($_GET["id_sucursal"]);
$client->eliminar();
Core::alert("Empresa eliminada con éxito");
Core::redir("index.php?view=sucursal");
?>