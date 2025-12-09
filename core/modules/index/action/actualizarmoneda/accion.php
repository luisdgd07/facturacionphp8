<?php
$monedas =  new MonedaData();
foreach ($_POST as $k => $v) {
	$monedas->$k = $v;
	# code...
}

 $monedas->actualizar();
$_SESSION["actualizar_datos"]= 1;
Core::redir("index.php?view=moneda&id_sucursal=".$_POST["id_sucursal"]);

?>