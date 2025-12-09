<?php
$update =  new ProductoData();
foreach ($_POST as $k => $v) {
	$update->$k = $v;
	# code...
}

 $update->acutualizarlistado();
$_SESSION["actualizar_datos"]= 1;
Core::redir("index.php?view=lista_precio&id_sucursal=".$_POST["id_sucursal"]);

?>