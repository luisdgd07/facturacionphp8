<?php

$accion = $_POST["accion"];
$sucursalId = $_POST['sucursal'];

if ($accion == "cboObtenerMonedas") { //trae los datos para el combo de tipo moneda ventas y compra
	echo json_encode(MonedaData::cboObtenerValorPorSucursal($sucursalId));
} else if ($accion == "obtenerCambioPorSimbolo") { //trae el cambio de la moneda por el simbolo
	$simbolo = $_POST["simbolo"];
	echo json_encode(MonedaData::obtenerCambioMonedaPorSimbolo($sucursalId, $simbolo));
}
