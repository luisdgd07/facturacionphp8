<?php





$update =  new AgenteData();
foreach ($_POST as $k => $v) {
	$update->$k = $v;
	# code...
}

 $update->actualizar1();
  Core::alert("Registro de agente actualizado correctamente");
 Core::redir("index.php?view=agente&id_sucursal=".$_POST["sucursal_id"]);





?>