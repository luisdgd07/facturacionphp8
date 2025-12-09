<?php
$sells = VentaData::cierre_caja1($_GET['id_sucursal']);

if(count($sells)){
	// $box = new CajaData::vercajasucursal($_GET["sucursal_id"]);
	$box = new CajaData();
	$box->sucursal_id = $_GET["id_sucursal"];
	$b = $box->cierre_caja_producto1();
	foreach($sells as $sell){
		$sell->caja_id = $b[1];
		$sell->actualizar_caja();
	}
	Core::redir("./index.php?view=cajaventas&id_venta=".$b[1]);
}

?>
