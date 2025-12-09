
<?php
$sells = VentaData::cierre_caja1porusuario($_GET['id_usuario']);

if(count($sells)){
	$box = new CajaData();
	$box->sucursal_id = $_GET["id_sucursal"];
	$box->usuario_id = $_GET["id_usuario"];
	$b = $box->cierre_caja_producto1porusuario();
	foreach($sells as $sell){
		$sell->caja_id = $b[1];
		$sell->actualizar_caja();
	}
	Core::redir("./index.php?view=cajaventas&id_venta=".$b[1]);
}

?>
