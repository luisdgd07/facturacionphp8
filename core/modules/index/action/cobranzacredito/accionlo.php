<?php

$check1 = $_POST["check"];
$sumatotal2 = 0;

$sumatotal = 0;

$saldo1 = $_POST["saldo_credito_cli"];
$monto1 = $_POST["monto"];
var_dump($check1);
// var_dump($monto1);
for ($i = 0; $i < count($check1); $i++) {


	
		// suma de lo cobrado
		$sumatotal = $sumatotal + $monto1[$i];
		echo $sumatotal;
		echo '<br>';
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
		//$jl2 = $s[1];
		$configuracionfactura->diferencia = ($jl1 - 1);
		$configuracionfactura->actualizardiferencia();
	}

	$registro1->RECIBO = $_POST["recibon"];
	$registro1->FECHA_COBRO = $_POST["fecha_recibo"];
	$registro1->configfactura_id = $_POST["configfactura_id"];
	$registro1->CLIENTE_ID = $_POST["cliente"];
	$registro1->TOTAL_COBRO = $sumatotal;
	$registro1->SUCURSAL_ID = $_POST["sucursal"];
	$registro1->MONEDA_ID = $_POST["moneda"];
	$id_cobro = $registro1->registro();


	// inicio Registro de detalle


	$saldo = $_POST["saldo_credito_cli"];
	$monto = $_POST["monto"];
	$suma = 0;
	$check = $_POST["check"];
	$factura = $_POST["factura"];
	$couta = $_POST["couta"];
	$credito = $_POST["credito"];
	$cliente = $_POST["cliente"];
	$importecred = $_POST["importecred"];
	$sucursall = $_POST["sucursall"];






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
			$registro2->SUCURSAL_ID = $sucursall[$i];
			$registro2->tipo = 0;
			$registro2->registro();

			//Core::redir("index.php?view=cobranza1&id_sucursal=".$_POST["sucursal"]);

		} else {

			Core::alert("Monto ingresado supera la deuda.....!");
		}
	}


	Core::alert("Registro de Cobro exitoso.....!");

	Core::redir("index.php?view=metodopago&id_sucursal=" . $_POST["sucursal"] . "&id_cobro=" . $id_cobro[1]);
} else {

	Core::alert("Monto ingresado supera la deuda.....!");
	Core::redir("index.php?view=cobranza1&id_sucursal=" . $_POST["sucursal"]);
}
