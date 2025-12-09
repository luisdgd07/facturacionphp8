<?php

$check1 = $_POST["check"];
$cobroid = $_POST["cobro_id"];
$sumatotal2 = 0;

$sumatotal = 0;

$saldo1 = $_POST["saldo_credito_cli"];
$monto1 = $_POST["monto"];
// var_dump($monto1);
for ($i = 0; $i < count($check1); $i++) {



	// suma de lo cobrado
	$sumatotal = $sumatotal + $monto1[$i];
	// suma de las cuotas
	$sumatotal2 = $sumatotal2 + $saldo1[$i];
}

if ($sumatotal <= $sumatotal2) {

	$registro1 = new CobroCabecera();


	$sell = new VentaData();

	$j1 = $_POST['serie1'];
	$j2 = "-";
	$j5 = $_POST['numeracion_final'];
	$j6 = $_POST['diferencia'];
	$j7 = ($j5 - $j6);
	$j8 = ($j5 - $j6);
	$nrofactura = "";

	if ($j8 >= 1 & $j8 < 10) {
		$nrofactura = $sell->factura = $j1 . "-" . "000000" . $j8;
	} else {
		if ($j8 >= 10 & $j8 < 100) {
			$nrofactura = $j1 . "-" . "00000" . $j8;
		} else {
			if ($j8 >= 100 & $j8 < 1000) {
				$nrofactura = $j1 . "-" . "0000" . $j8;
			} else {
				if ($j8 >= 1000 & $j8 < 10000) {
					$nrofactura = $j1 . "-" . "000" . $j8;
				} else {
					if ($j8 >= 100000 & $j8 < 1000000) {
						$nrofactura = $j1 . "-" . "00" . $j8;
					} else {
						if ($j8 >= 1000000 & $j8 < 10000000) {
							$nrofactura = $j1 . "-" . "0" . $j8;
						} else {
						}
					}
				}
			}
		}
	}



	if (count($_POST) > 0) {
		$configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
		$jl1 = $_POST["diferencia"];
		$configuracionfactura->diferencia = ($jl1 - 1);
		$configuracionfactura->actualizardiferencia();
	}

	$registro1->RECIBO = $_POST["recibon"];
	$registro1->FECHA_COBRO = $_POST["fecha"];
	$registro1->configfactura_id = $_POST["configfactura_id"];
	$registro1->CLIENTE_ID = $_POST["cliente"];
	$registro1->TOTAL_COBRO = $sumatotal;
	$registro1->SUCURSAL_ID = $_POST["sucursal"];
	$registro1->MONEDA_ID = $_POST["moneda"];
	$id_cobro = $registro1->registro();



	$saldo = $_POST["saldo_credito_cli"];
	$monto = $_POST["monto"];
	$suma = 0;
	$check = $_POST["check"];
	$factura = $_POST["factura"];
	$couta = $_POST["couta"];
	$credito = $_POST["credito"];
	$cliente = $_POST["cliente"];
	$importecred = $_POST["importecred"];



	$res = 0;


	for ($i = 0; $i < count($check); $i++) {


		if ($monto[$i] <= $saldo[$i]) {
			$registro = new CreditoDetalleData();
			$registro->id = $check[$i];




			$suma = $saldo[$i] - $monto[$i];


			$registro->saldo_credito = $suma;



			$registro->pagos();
			$registro2 = new CobroDetalleData();
			$registro2->COBRO_ID = $id_cobro[1];
			$registro2->NUMERO_FACTURA = $factura[$i];
			$registro2->CUOTA = $couta[$i];
			$registro2->NUMERO_CREDITO = $credito[$i];
			$registro2->CLIENTE_ID = $cliente;     // probar id cliente si carga bien
			$registro2->IMPORTE_COBRO = $monto[$i];
			$registro2->IMPORTE_CREDITO = $importecred[$i];
			$registro2->SUCURSAL_ID = $_POST["sucursal"];;
			$registro2->tipo = 0;
			$registro2->registro();
		} else {
			echo -1;
			// Core::alert("Monto ingresado supera la deuda.....!");
		}
	}
	if ($res == 0) {
		$pagos = $_POST['pagos'];
		$esretencion = false;
		$retencion = 0;
		$numret = 0;
		$tipo = '';
		$timbrado = '';
		$montoRetencion = 0;
		foreach ($pagos as $pago) {

			if ($pago['fecha'] != '') {
				$esretencion = true;
				$retencion = $pago['numret'];
				$tipo = $pago['tiporet'];
				$timbrado = $pago['usuario'];
				$montoRetencion += $pago['monto'];
			}
		}
		if ($esretencion) {
			$caja = new RetencionData();
			$caja->periodo = 1;
			$caja->cobro = $id_cobro[1];
			$caja->cliente = $_POST['cliente'];
			$caja->factura = $factura[0];
			$caja->importe = $_POST['total'];
			$caja->fecha = $_POST['fecha'];
			$caja->usuario = $_POST['sucursal'];
			$caja->retencion = $retencion;
			$caja->timbrado = $timbrado;
			$caja->tipo = $tipo;
			$caja->monto = $montoRetencion;
			$caja->sucursal = $_POST['sucursal'];
			if (isset($_POST['concepto'])) {
				$caja->concepto = $_POST['concepto'];
				$caja->fecha = $_POST['fecha'];
			} else {
				$caja->concepto = '';
				$caja->fecha = date('d/m/y');
			}
			$numret = $caja->agregar();
			foreach ($pagos as $pago) {
				// $pago = json_encode($pago);

			}
		}
		$pagos = $_POST['pagos'];
		$caja = new CajaCabecera();
		$caja->cobroId = $_POST['cobro'];
		$caja->clienteId = $_POST['cliente'];
		$caja->total = $_POST['total'];
		$caja->sucursal = $_POST['sucursal'];
		if (isset($_POST['concepto'])) {
			$caja->concepto = $_POST['concepto'];
			$caja->fecha = $_POST['fecha'];
		} else {
			$caja->concepto = '';
			$caja->fecha = date('d/m/y');
		}
		$cajaCa = $caja->agregarCaja();
		foreach ($pagos as $pago) {
			// $pago = json_encode($pago);
			if ($pago['fecha'] != '') {
				$detalle = new RetencionDetalleData();
				$detalle->periodo = $_POST['cobro'];
				$detalle->cliente = $_POST['cliente'];
				$detalle->sucursal = $_POST['sucursal'];
				// $detalle->factura = $pago['factura'];
				$detalle->factura = $factura[0];
				$detalle->retencion = $pago['tiporet'];


				$detalle->fecha = $pago['fecha'];
				$detalle->importe = $pago['monto'];
				$detalle->fechaauditoria = $pago['fecha'];
				$detalle->tipo = $pago['tipo'];
				$detalle->tipo_cierre = '';
				$detalle->num = $pago['usuario'];
				$detalle->tipoproveedor = '';
				$detalle->usuarion = $numret[1];
				$d = $detalle->agregar();
			}
			$detalle = new CajaDetalle();
			$detalle->cobroId = $_POST['cobro'];
			$detalle->clienteId = $_POST['cliente'];
			$detalle->importe = $pago['monto'];
			$detalle->caja = $pago['tipo_id'];


			$detalle->moneda = $pago['moneda_id'];
			$detalle->cambio = $pago['cambio'];
			$detalle->sucursal = $_POST['sucursal'];

			$d = $detalle->agregarDetalle();
			if ($pago['vaucher'] != 0) {
				$tarjeta = new TarjetaCabecera();
				$tarjeta->transaccion = $pago['tipo_tar'];
				$tarjeta->importe = $pago['monto'];
				$tarjeta->tarjeta_id = $cajaCa[1];
				$t = $tarjeta->agregarTarjeta();

				$tarjetad = new TarjetaDetalleData();
				$tarjetad->tarjeta = $t[1];
				$tarjetad->transaccion = $d[1];
				$tarjetad->vaucher = $pago['vaucher'];
				$tarjetad->procesadora = $pago['tipo_tar'];
				$tarjetad->importe = $pago['monto'];
				$tarjetad->tipo = $pago['tarjeta'];
				$t2 = $tarjetad->agregarTarjeta();
			}
		}



		echo json_encode($cajaCa);
	} else {
		echo -1;
	}

	// Core::alert("Registro de Cobro exitoso.....!");
	// Core::redir("impresioncobro.php?concepto=&fecha=" . $_POST["fecha_recibo"] . "&cobro=$cobroid");
	// Core::redir("index.php?view=metodopago&id_sucursal=" . $_POST["sucursal"] . "&id_cobro=" . $id_cobro[1]);
} else {

	// Core::alert("Monto ingresado supera la deuda.....!");
	// Core::redir("index.php?view=cobranza1&id_sucursal=" . $_POST["sucursal"]);
	echo -1;
}
