<?php
$update = VentaData::getById($_GET["id_venta"]);
$update->actualizarestado();
$operations = OperationData::getAllProductsBySellIddd($_GET['id_venta']);

// 1. Obtener operaciones antes de eliminar la venta
$operations = OperationData::getAllProductsBySellIddd($_GET['id_venta']);

// 2. Actualizar stock y registrar transacciones
foreach ($operations as $op) {
    $stockActual = StockData::vercontenidos3($op->producto_id, $op->deposito);
    $actualizar = new StockData();
    $suma = $stockActual->CANTIDAD_STOCK + $op->q;
    $actualizar->CANTIDAD_STOCK = $suma;
    $actualizar->DEPOSITO_ID = $op->deposito;
    $actualizar->PRODUCTO_ID = $op->producto_id;
    $res = $actualizar->actualizar();

    $sell = new VentaData();
    $sell->usuario_id = $_SESSION["admin_id"];
    $a = $_GET["id_sucursal"];
    $j = AccionData::getByName("entrada")->id_accion;
    $sell->accion_id = $j;
    $sell->sucursal_id = $a;
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
    $op3 = $opd->registrotransaccionD();
}


$venta = OperationData::eliminarVenta($_GET['id_venta']);
CobroDetalleData::eliminarVentaCliente($update->factura, $update->cliente_id);
CobroCabecera::eliminarVentaCliente($update->factura, $update->cliente_id);

// 3. Eliminar la venta y cobros relacionados
VentaData::eliminar($_GET['id_venta']);
Core::alert("Registro eliminado  con éxito");
Core::redir("index.php?view=ventas&id_sucursal=" . $_GET["id_sucursal"]);
