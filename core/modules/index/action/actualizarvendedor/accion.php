<?php





$update =  new VendedorData();
foreach ($_POST as $k => $v) {
	$update->$k = $v;
	# code...
}

 $update->actualizar1();
  Core::alert("Registro del vendedor actualizado correctamente");
 Core::redir("index.php?view=vended&id_sucursal=".$_POST["sucursal_id"]);





?>