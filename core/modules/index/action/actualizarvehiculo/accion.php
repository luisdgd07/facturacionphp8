<?php
$update =  new VehiculoData();
foreach ($_POST as $k => $v) {
	$update->$k = $v;
	# code...
}

 $update->actualizar1();
  Core::alert("Registro de vehiculo actualizado correctamente");
 Core::redir("index.php?view=vehiculos&id_sucursal=".$_POST["sucursal_id"]);
?>