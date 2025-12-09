<?php
$empleado =  new ProductoData();
foreach ($_POST as $k => $v) {
	$empleado->$k = $v;
	# code...
}
$handle = new Upload($_FILES['imagen']);
if ($handle->uploaded) {
	$url = "storage/producto/";
	$handle->Process($url);

	$empleado->imagen = $handle->file_dst_name;
	$empleado->actualizar_imagen();
}
if (isset($_POST["activo"])) {
	$empleado->activo = 1;
} else {
	$empleado->activo = 0;
}
$empleado->actualizar_Producto();



$actualizar = new StockData();
$actualizar->PRODUCTO_ID = $_POST["id_producto"];
$actualizar->DEPOSITO_ID = $_POST["id_deposito"];

$actualizar->COSTO_COMPRA = $_POST["precio_compra"];
$actualizar->MINIMO_STOCK = $_POST["inventario_minimo"];
$actualizar->actualizarprecio();




$_SESSION["actualizar_datos"] = 1;

// Core::alert("PRODUCTO ACTUALIZADO CON EXITO");
// Core::redir("index.php?view=producto&id_sucursal=".$_POST["id_sucursal"]);
