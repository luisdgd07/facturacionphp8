<?php
TarjetaDetalleData::eliminar($_GET['id']);
TarjetaCabecera::eliminar($_GET['id']);
Core::alert("Registro eliminado  con éxito");
Core::redir("index.php?view=tarjeta&id_sucursal=" . $_GET["id_sucursal"]);
