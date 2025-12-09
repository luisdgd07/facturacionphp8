<?php
$update =  new PlacaData();
foreach ($_POST as $k => $v) {
	$update->$k = $v;
	# code...
}

 $update->actualizar1();
  Core::alert("Registro de placa actualizada correctamente");
 Core::redir("index.php?view=placa_fabrica&id_sucursal=".$_POST["sucursal_id"]);
?>