
<?php
$sells = VentaData::cierre_caja1porusuario($_GET['id_usuario']);

if(count($sells)){
	$box = new CajaData();
	$box->total = $_GET["total"];
	$box->sucursal_id = $_GET["id_sucursal"];
	$box->usuario_id = $_GET["id_usuario"];
	$box->id_caja = $_GET["id_caja"];
	$box->accion = $_GET["accion"];
	$b = $box->registrodecuierrecajaporusuario();
	foreach($sells as $sell){
		$sell->caja_id = $_GET["id_caja"];
		$sell->actualizar_caja();
	}
	Core::redir("./index.php?view=cajaventas&id_venta=".$_GET["id_caja"]);
}

?>
