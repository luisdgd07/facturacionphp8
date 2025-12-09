<?php
$registro1=new CobroCabecera();
		$j1 = $_POST['serie1'];
		$j2 = "-";
		$j5 = $_POST['numeracion_final'];
		$j6 = $_POST['diferencia'];
		$j7 = ($j5 - $j6);
		$j8 = ($j5 - $j6);
		if ($j8 >= 1 & $j8 < 10) {
			$registro1->RECIBO = $j1 . "-" . "000000" . $j8;
		} else {
			if ($j8 >= 10 & $j8 < 100) {
			$registro1->RECIBO = $j1 . "-" . "00000" . $j8;
			} else {
				if ($j8 >= 100 & $j8 < 1000) {
					$registro1->RECIBO = $j1 . "-" . "0000" . $j8;
				} else {
					if ($j8 >= 1000 & $j8 < 10000) {
					$registro1->RECIBO = $j1 . "-" . "000" . $j8;
					} else {
						if ($j8 >= 100000 & $j8 < 1000000) {
							$registro1->RECIBO = $j1 . "-" . "00" . $j8;
						} else {
							if ($j8 >= 1000000 & $j8 < 10000000) {
								$registro1->RECIBO = $j1 . "-" . "0" . $j8;
							} else {
							}
						}
					}
				}
			}
		}
//$registro1->RECIBO=$nrofactura;
$registro1->configfactura_id = $_POST["configfactura_id"];
$registro1->CLIENTE_ID=$_POST["cliente"];
$registro1->TOTAL_COBRO=$_POST["total"];
$registro1->SUCURSAL_ID=$_POST["sucursal"];
$registro1->MONEDA_ID=$_POST["moneda"];
$id_cobro = $registro1->registro();
$check=$_POST["check"];
$monto=$_POST["monto"];
// -----------------
$factura=$_POST["factura"];
$couta=$_POST["couta"];
$credito=$_POST["credito"];
$cliente=$_POST["cliente"];
$importecred=$_POST["importecred"];
$sucursall=$_POST["sucursall"];
for ($i=0; $i < count($check) ; $i++) { 
if ($check[$i]=="") {
	
} else {
	$registro= new CreditoDetalleData();
    $registro->id=$check[$i];
    $registro->saldo_credito=$monto[$i];
    $registro->pagos();   
    $registro2= new CobroDetalleData();
    $registro2->COBRO_ID=$id_cobro[1];
    $registro2->NUMERO_FACTURA=$factura[$i];
    $registro2->CUOTA=$couta[$i];
    $registro2->NUMERO_CREDITO=$credito[$i];
    $registro2->CLIENTE_ID=$cliente[$i];
    $registro2->IMPORTE_COBRO=$monto[$i];
    $registro2->IMPORTE_CREDITO=$importecred[$i];
    $registro2->SUCURSAL_ID=$sucursall[$i];
    $registro2->registro();   
   	if (count($_POST) > 0) {
			$configuracionfactura = ConfigFacturaData::VerId($_POST["configfactura_id"]);
			$jl1 = $_POST["diferencia"];
			$jl2 = $s[1];
			$configuracionfactura->diferencia = ($jl1 - 1);
			$configuracionfactura->actualizardiferencia();
		}
	Core::redir("index.php?view=cobranza1&id_sucursal=".$_POST["sucursal"]);
}
}
?>