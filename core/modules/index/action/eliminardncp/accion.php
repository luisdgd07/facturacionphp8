<?php
DNCPData::eliminar($_GET['id']);
// 3. Eliminar la venta y cobros relacionados
Core::alert("Registro eliminado  con éxito");
Core::redir("index.php?view=listadncp&id_sucursal=" . $_GET["id_sucursal"]);
