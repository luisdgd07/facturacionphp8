<?php

if ($_GET["accion_id"] == 1) {
    $actualizar2 = new VentaData();
    $actualizar3 = new OperationData();
    $b = $actualizar2->eliminar($_GET['id_venta']);
    $c = $actualizar3->eliminar($_GET['id_pro']);
    $stock2 = StockData::vercontenidos3($_GET["producto_id"], $_GET["id_deposito"]);

    $actualizar = new StockData();
    $resta = $stock2->CANTIDAD_STOCK - $_GET["q"];
    $actualizar->CANTIDAD_STOCK =    $resta;
    $actualizar->DEPOSITO_ID = $_GET["id_deposito"];
    $actualizar->PRODUCTO_ID = $_GET["producto_id"];
    $a = $actualizar->actualizar2();

    Core::alert("Entrada realizada con exito...!");
    Core::redir("index.php?view=transa&id_sucursal=" . $_GET['id_sucursal']);
}
if ($_GET["accion_id"] == 2) {
    $actualizar2 = new VentaData();
    $actualizar3 = new OperationData();
    $b = $actualizar2->eliminar($_GET['id_venta']);
    $c = $actualizar3->eliminar($_GET['id_pro']);
    $stock2 = StockData::vercontenidos3($_GET["producto_id"], $_GET["id_deposito"]);

    $actualizar = new StockData();
    $resta = $stock2->CANTIDAD_STOCK + $_GET["q"];
    $actualizar->CANTIDAD_STOCK =    $resta;
    $actualizar->DEPOSITO_ID = $_GET["id_deposito"];
    $actualizar->PRODUCTO_ID = $_GET["producto_id"];
    $a = $actualizar->actualizar2();

    Core::alert("Entrada anulada con exito...!");
    Core::redir("index.php?view=transa&id_sucursal=" . $_GET['id_sucursal']);
}
if ($_GET["accion_id"] == 3) {
    $actualizar2 = new VentaData();
    $actualizar3 = new OperationData();
    $b = $actualizar2->eliminar($_GET['id_venta']);
    $c = $actualizar3->eliminar($_GET['id_pro']);
    $stock2 = StockData::vercontenidos3($_GET["producto_id"], $_GET["id_deposito"]);
    $stock3 = StockData::vercontenidos3($_GET["producto_id"], $_GET["id_deposito2"]);
    $actualizar = new StockData();
    $resta = $stock2->CANTIDAD_STOCK - $_GET["q"];
    $actualizar->CANTIDAD_STOCK =    $resta;
    $actualizar->DEPOSITO_ID = $_GET["id_deposito"];
    $actualizar->PRODUCTO_ID = $_GET["producto_id"];
    $a = $actualizar->actualizar2();
    $actualizar = new StockData();
    $resta = $stock3->CANTIDAD_STOCK + $_GET["q"];
    $actualizar->CANTIDAD_STOCK =    $resta;
    $actualizar->DEPOSITO_ID = $_GET["id_deposito2"];
    $actualizar->PRODUCTO_ID = $_GET["producto_id"];
    $a = $actualizar->actualizar2();
    Core::alert("Salida anulada con exito...!");
    Core::redir("index.php?view=transa&id_sucursal=" . $_GET['id_sucursal']);
}
