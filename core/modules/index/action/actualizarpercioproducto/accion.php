<?php
$update =  new ProductoData();
foreach ($_POST as $k => $v) {
	$update->$k = $v;
	# code...
}

 $update->acutualizarprecio_prod();
$_SESSION["actualizar_datos"]= 1;
Core::redir("index.php?view=producto_precio&id_sucursal=".$_POST["id_sucursal"]);

?>