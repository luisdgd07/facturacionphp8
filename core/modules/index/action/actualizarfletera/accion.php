<?php
$update =  new FleteraData();
foreach ($_POST as $k => $v) {
	$update->$k = $v;
	# code...
}

 $update->actualizar1();
  Core::alert("Registro de Empresa fletera actualizada correctamente");
 Core::redir("index.php?view=fletera&id_sucursal=".$_POST["sucursal_id"]);
?>