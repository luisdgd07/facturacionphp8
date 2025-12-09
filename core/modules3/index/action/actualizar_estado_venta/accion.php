<?php

$fechaD = new DateTime();

$fecha = $fechaD->format("Y-m-d");
var_dump($fecha);
$update = VentaData::getById($_GET["id_venta"]);
$update->actualizarestado();
$operations = OperationData::getAllProductsBySellIddd($_GET['id_venta']);
// foreach ($operations as $op) {

//     $stockActual = StockData::vercontenidos3($op->producto_id, $op->deposito);
//     // var_dump($stockActual);
//     $actualizar = new StockData();
//     $suma = $stockActual->CANTIDAD_STOCK + $op->q;
//     $actualizar->CANTIDAD_STOCK =    $suma;
//     $actualizar->DEPOSITO_ID = $op->deposito;
//     $actualizar->PRODUCTO_ID = $op->producto_id;
//     $res = $actualizar->actualizar();
// }
foreach ($operations as $op) {

    $stockActual = StockData::vercontenidos3($op->producto_id, $op->deposito);
    // var_dump($stockActual);
    $actualizar = new StockData();
    $suma = $stockActual->CANTIDAD_STOCK + $op->q;
    $actualizar->CANTIDAD_STOCK =    $suma;
    $actualizar->DEPOSITO_ID = $op->deposito;
    $actualizar->PRODUCTO_ID = $op->producto_id;
    $res = $actualizar->actualizar();

    // $op6 = new OperationData();
    // $op6->producto_id = $op->producto_id;
    // $op6->precio = 0;
    // $op6->accion_id = AccionData::getByName("entrada")->id_accion;
    // $op6->q = $op->q;
    // $op6->is_oficiall = 1;
    // $op6->sucursal_id = $_GET["id_sucursal"];
    // $op6->SUCURSAL_ID = $op->sucursal_id;
    // $op6->DEPOSITO_ID = 0;
    // $op6->MINIMO_STOCK = 0;
    // $op6->DEPOSITO_ID = 0;
    // $op6->venta_id = $_GET["id_venta"];
    // $op6->COSTO_COMPRA = 0;

    // $p = $op6->registro_productoa();

    $sell = new VentaData();
    $sell->usuario_id = $_SESSION["admin_id"];
    $a = $_GET["id_sucursal"];
    $j = AccionData::getByName("entrada")->id_accion;
    $sell->accion_id = $j;
    $sell->sucursal_id = $a;
    // $opd->fecha = "NOW()";
    $s = $sell->registrotranasaccionD();

    $opd = new OperationData();
    $opd->id_deposito = $op->deposito;

    $opd->producto_id = $op->producto_id;
    $m = AccionData::getByName("entrada")->id_accion;
    $stc = $op->q;
    $opd->stock_trans = $stc;
    $opd->accion_id = $m;
    $opd->venta_id = $s[1];
    $b = $_GET["id_sucursal"];
    $opd->sucursal_id = $b;
    $opd->q = $op->q;
    $opd->motivo = '';
    $opd->observacion = "";
    // $opd->fecha = "NOW()";




    $op3 = $opd->registrotransaccionD();
    // var_dump($op->deposito);
    // echo "<br>";
    // $p = $op6->registro_producto1();
    var_dump($op3);
}
Core::alert("Registro anulado  con éxito");
Core::redir("index.php?view=ventas&id_sucursal=" . $_GET["id_sucursal"]);
