<?php
RetencionDetalleData::eliminar($_GET['id']);
Core::alert("Registro eliminado  con éxito");
Core::redir("index.php?view=retencion&id_sucursal=" . $_GET["id_sucursal"]);
