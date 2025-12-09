<?php
$update =  new ConfigFacturaData();
foreach ($_POST as $k => $v) {
	$update->$k = $v;
	# code...
}

 $update->actualizar1();
  Core::alert("Configuracion actualizada");
Core::redir("index.php?view=cofigfactura&id_sucursal=".$_POST["id_sucursal"]);
?>