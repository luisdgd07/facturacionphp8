<?php
$update =  new MarcaData();
foreach ($_POST as $k => $v) {
	$update->$k = $v;
	# code...
}

 $update->actualizar();
$_SESSION["actualizar_datos"]= 1;
Core::redir("index.php?view=marca&id_sucursal=".$_POST["id_sucursal"]);

?>