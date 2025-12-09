<?php



$update = VentaData::getById($_GET["id_venta"]);
$update->actualizarestado();
// $operations = OperationData::getAllProductsBySellIddd($_GET['id_venta']);
// foreach ($operations as $op) {

//     $stockActual = StockData::vercontenidos3($op->producto_id, $op->deposito);
//     // var_dump($stockActual);
//     $actualizar = new StockData();
//     $suma = $stockActual->CANTIDAD_STOCK + $op->q;
//     $actualizar->CANTIDAD_STOCK =    $suma;
//     $actualizar->DEPOSITO_ID = $op->deposito;
//     $actualizar->PRODUCTO_ID = $op->producto_id;
//     $res = $actualizar->actualizar();
//     var_dump($res);
// }

Core::alert("Registro anulado con éxito");
Core::redir("index.php?view=ventas&id_sucursal=" . $_GET["id_sucursal"]);
