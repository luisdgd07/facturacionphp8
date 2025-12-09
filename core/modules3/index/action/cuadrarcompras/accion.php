<?php
$cliente =  new CompraData();
foreach ($_POST as $k => $v) {
	$cliente->$k = $v;
	# code...
}

 $cliente->Actualizar_gasto();
$_SESSION["actualizar_datos"]= 1;
// Core::redir("index.php?view=micompra&id_compra=$_POST[id_compra]");
Core::redir("index.php?view=compras");
?>