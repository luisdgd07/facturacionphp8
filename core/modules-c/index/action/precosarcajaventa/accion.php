<?php
$sells = VentaData::cierre_caja();

if(count($sells)){
	$box = new CajaData();
	$b = $box->cierre_caja_producto();
	foreach($sells as $sell){
		$sell->caja_id = $b[1];
		$sell->actualizar_caja();
	}
	Core::redir("./index.php?view=cajaventas&id_venta=".$b[1]);
}

?>