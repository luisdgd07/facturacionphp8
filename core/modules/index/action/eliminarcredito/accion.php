<?php
CreditoDetalleData::eliminarCredito($_GET['id']);
CreditoData::eliminarCredito($_GET['id']);

// 3. Eliminar la venta y cobros relacionados
Core::alert("Registro eliminado  con éxito");
Core::redir("index.php?view=listacredito&id_sucursal=" . $_GET["id_sucursal"]);
