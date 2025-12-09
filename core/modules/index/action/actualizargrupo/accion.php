<?php
$empleado =  new GrupoData();
foreach ($_POST as $k => $v) {
	$empleado->$k = $v;
	# code...
}

 $empleado->actualizar();
$_SESSION["actualizar_datos"]= 1;
Core::redir("index.php?view=grupos&id_sucursal=".$_POST["id_sucursal"]);

?>