<?php
CajaDetalle::eliminarCobro($_GET['id']);
CajaCabecera::eliminarCobro($_GET['id']);
// 3. Eliminar la venta y cobros relacionados
Core::alert("Registro eliminado  con éxito");
Core::redir("index.php?view=cobrocaja&id_sucursal=" . $_GET["id_sucursal"]);
