<?php

include "./PDF.php";
$pdf = new PDF();
$sd = date("d-m-Y", strtotime($_GET['sd']));
$ed = date("d-m-Y", strtotime($_GET['ed']));
$title = 'Reporte de Entradas y Salidas desde: ' . $sd . ' Hasta: ' . $ed;
$pdf->SetTitle($title);
$pdf->SetY(65);

$cols = [
    'Nro.',
    'Producto.',
    'Cajas',
    'Tipo de transaccion',
    'Usuario',
    'Fecha'
];
$width = [20, 60, 20, 25, 25, 25, 20];
$rows = [];
$total = 0;
$totall = 0;
$total = 0;
$totall = 0;
$sucur = SuccursalData::VerId($_GET["id_sucursal"]);
$total = 0;
$totalg = 0;
$totali = 0;
$totalg5 = 0;
$totalii5 = 0;
$totalexent = 0;
$totalusd = 0;
$totalcajas = 0;
$cambio = 0;
$j = 0;
$opr[0] = array(
    'Nro.',
    'Producto.',
    'Cajas',
    'Tipo de transaccion',
    'Usuario',
    'Obnservacion',
    'Fecha'
);
$adi = 0;
$k = 1;
$operations  = VentaData::versucursaltipotrans2($_GET["id_sucursal"], $_GET["sd"], $_GET["ed"]);
foreach ($operations as $operation) {
    $sells = OperationData::getAllProductsBySellIddd($operation->id_venta);



    $total = 0;
    $totalg = 0;
    $totali = 0;

    $totalg5 = 0;
    $totalii5 = 0;
    $totalexent = 0;
    $totalusd = 0;

    $cambio = 0;
    $j = 0;

    foreach ($sells as $selldetalle) {
        $totalproducts = 0;
        // $totalg = $totalg + $operation->total10;
        // $totali = $totali + $operation->iva10;

        // $totalg5 = $totalg5 + $operation->total5;
        // $totalii5 = $totalii5 + $operation->iva5;
        // $totalexent = $totalexent + $operation->exenta;



        // if ($operation->simbolo2 == "US$") {
        //     $cambio = $operation->cambio;
        // } else if (($operation->simbolo2 == "₲") and  ($operation->cambio == 1)) {
        //     $cambio = $operation->cambio2;
        // } else if (($operation->simbolo2 == "₲") and  ($operation->cambio > 1)) {
        //     $cambio = 1;
        // }


        // $cambio = $operation->cambio2;
        // $total = $total + ($operation->total - $operation->descuento) * $cambio;

        // $totalusd = $totalusd + $operation->total;



        $prod = ProductoData::getProducto2($selldetalle->producto_id);
        $detalleProd = "";

        foreach ($prod as $detalle) :
            $detalleProd =  $detalle->nombre;
        endforeach;

        $tipoOp = "";
        if ($operation->accion_id == 1) {
            $tipoOp =  "Entrada";
        } else if ($operation->accion_id == 2) {
            $tipoOp = "Salida";
        } else if ($operation->accion_id == 3) {
            $tipoOp = "Trasferencia";
        }
        $usuario = "";
        if ($operation->usuario_id != "") {
            $user = $operation->getUser();
            $usuario = $user->nombre . " " . $user->apellido;
        }
        if ($k % 39  == $adi) {

            $opr[$k] = array(
                "Total pagina",
                '',
                $totalcajas,
                '',
                '',

                '',
                ''
            );
            $k++;
            $adi++;
        }
        if ($_GET['prod'] == "todos") {
            $totalcajas
                += $selldetalle->q;
            $opr[$k] = array(
                // $k,
                $operation->id_venta,
                $detalleProd, $selldetalle->q, $tipoOp, $usuario, $selldetalle->observacion, $operation->fecha
            );
            $k++;
        } else if ($selldetalle->producto_id == $_GET['prod']) {
            $totalcajas
                += $selldetalle->q;
            $opr[$k] = array($operation->id_venta, $detalleProd, $selldetalle->q, $tipoOp, $usuario, $selldetalle->observacion, $operation->fecha);
            $k++;
        }
    }
    $j += 1;



    // var_dump($opr[$k]);
    // echo '<br>';
    // $k++;

    // if ($k % 50 == 0 && $k !== 50) {

    //     $opr[$k] = array(
    //         "Total pagina",
    //         '',
    //         '',
    //         '',
    //         number_format($totalg5, 0, ',', '.'),
    //         number_format($totalg, 0, ',', '.'),
    //         number_format($totalexent, 0, ',', '.'),
    //         number_format($totalii5, 0, ',', '.'),
    //         number_format($totali, 0, ',', '.'),
    //         ''
    //     );
    //     $k++;
    //     $opr[$k] = array(
    //         'Fecha',
    //         'Cliente',
    //         'Factura',
    //         'RUC',
    //         'Gravada 5',
    //         'Gravada 10',
    //         'Exentas',
    //         'IVA 5',
    //         'IVA 10',
    //         'Timbrado',
    //     );
    //     $k++;
    // }
}
$opr[$k] = array(
    "Total",
    '',
    $totalcajas,
    '',

    '',
    '',
    ''
);
// var_dump($opr);
$pdf->imprimirReporte($cols, $width, $opr, true);
$pdf->Output();
