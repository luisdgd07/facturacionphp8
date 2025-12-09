<?php
$update =  new ChoferData();
foreach ($_POST as $k => $v) {
	$update->$k = $v;
	# code...
}

 $update->actualizar1();
  Core::alert("Registro de Chofer actualizada correctamente");
 Core::redir("index.php?view=choferes&id_sucursal=".$_POST["sucursal_id"]);
?>