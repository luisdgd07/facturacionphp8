<?php
try {

	$sell = new VentaData();
	$sell->usuario_id = $_SESSION["admin_id"];
	$sell->formapago2 = $_POST["formapago2"];
	$sell->comprobante2 = $_POST["comprobante2"];
	$sell->timbrado2 = $_POST["timbrado2"];
	$sell->codigo2 = $_POST["codigo2"];
	$sell->fecha2 = $_POST["fecha2"];
	$sell->cambio = $_POST["cambio"];
	$sell->cambio2 = $_POST["cambio2"];
	$sell->simbolo2 = $_POST["simbolo2"];
	$grabada102 = str_replace(',', '', $_POST["grabada102"]);
	$sell->grabada102 =  $grabada102;
	$iva102 = str_replace(',', '', $_POST["iva102"]);
	$sell->iva102 = $iva102;
	$grabada52 = str_replace(',', '', $_POST["grabada52"]);
	$sell->grabada52 = $grabada52;
	$iva52 = str_replace(',', '', $_POST["iva52"]);
	$sell->iva52 = $iva52;
	$excenta2 = str_replace(',', '', $_POST["excenta2"]);
	$sell->excenta2 = $excenta2;
	$sell->total = $_POST["total"];
	$sell->tipomoneda_id = $_POST["idtipomoneda"];
	$sell->sucursal_id = $_POST['id_sucursal'];
	$sell->fecha = $_POST["fecha"];
	$sell->cliente_id = $_POST["cliente_id"];
	$sell->metodopago = $_POST["condicioncompra"];
	$cart = $_POST["carrito"];
	$s = $sell->abastecer_producto_proveedor1();

	if ($_POST["condicioncompra"] == "Credito") {
		$fecha_actual = $_POST['fecha'];
		$vence = date("Y-m-d", strtotime($fecha_actual . "+ " . $_POST['vencimiento'] . " days"));
		$credito = CreditoCompraData::registrar_credito($s[1], $_POST["fecha"], $_POST['id_sucursal'],  $_POST["idtipomoneda"], $_POST["concepto"], $_POST["total"], 0, $vence, $_POST["cuotas"], $_POST["cliente_id"]);
		for ($i = 0; $i < $_POST["cuotas"]; $i++) {
			CreditoCompraDetalleData::registrar_credito($i + 1, $credito, $_POST["total"] / $_POST["cuotas"], $_POST["fecha"], $s[1], 0, $_POST["fecha"], $_POST['id_sucursal']);
		}
		$sell->formapago = null;
	} else {
		$sell->formapago = $_POST["tipopago_id"];
	}
	foreach ($cart as  $c) {
		$op = new OperationData();
		$op->producto_id = $c["id"];

		// $stc = $_POST["stock_trans"];
		$op->stock_trans = 0;
		$op->fecha = $_POST["fecha"];
		$op->motivo = "COMPRA" . " " . $s[1];

		$op->accion_id = 1; // 1 - entrada
		$op->venta_id = $s[1];
		$op->q = $c["q"];
		$op->precio = $c["precio"];
		$op->precio1 = $c["precio"];
		$op->deposito_nombre = $c["depositotext"];
		$op->deposito = $c["deposito"];
		$b1 = $_POST['id_sucursal'];
		$op->sucursal_id = $b1;

		if (isset($_POST["is_oficiall"])) {
			$op->is_oficiall = 1;
		}
		$add = $op->registro_producto1();
		$actualizar = new StockData();
		$suma = $c["stock"] + $c["q"];
		$actualizar->CANTIDAD_STOCK =	$suma;
		$actualizar->DEPOSITO_ID =	$c["deposito"];
		$actualizar->PRODUCTO_ID = $c["id"];
		$actuali = $actualizar->actualizar();
	}
	if ($cart[1]) {
		echo 1;
	}
	echo 0;
} catch (Exception $e) {
	echo 0;
}
