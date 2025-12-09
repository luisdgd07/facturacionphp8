<?php
$empleado =  new CategoriaData();
foreach ($_POST as $k => $v) {
	$empleado->$k = $v;
	# code...
}

 $empleado->actualizar();
$_SESSION["actualizar_datos"]= 1;
Core::redir("index.php?view=categoria&id_sucursal=".$_POST["id_sucursal"]);

?>