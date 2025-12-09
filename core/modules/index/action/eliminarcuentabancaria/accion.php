<?php
CuentaBancariaData::eliminar($_GET['id']);
// 3. Eliminar la venta y cobros relacionados
Core::alert("Registro de cuenta bancaria eliminado  con éxito");
Core::redir("index.php?view=cuentabancaria&id_sucursal=" . $_GET["id_sucursal"]);
