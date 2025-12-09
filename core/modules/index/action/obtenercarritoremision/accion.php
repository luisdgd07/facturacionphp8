<?php
$cart = OperationData::getAllProductsBySellIddd($_GET['tid']);
$venta = VentaData::getByIdRemision($_GET['tid']);
// $result = [];
// // ProductoData::
// array_push($result, array("cantidad" => $q, "tipo" => $tipo->TIPO_PRODUCTO, "producto" => $product));
// header("Content-type:application/json");
// $jsdata = json_decode(file_get_contents('php://input'), true);
// header("HTTP/1.1 200 OK");
// header('Content-Type: text/plain');
// // echo json_encode($cart);
$result = [];
$tipo = ProductoData::verinsumo($_GET['sucursal']);
$insumo = $tipo->ID_TIPO_PROD;
foreach ($cart as $c) {
    // $c
    $product = ProductoData::getById($c->producto_id);

    if ($product->ID_TIPO_PROD == $insumo) {
    } else {
        $q = 0;
        $precio = 0;
        // $extraerdata  = ProductoData::listar_precio_productos($c->producto_id);
        $cliente = ClienteData::getById($venta->cliente_id);
        $extraerdata  = ProductoData::listar_precio_productos2($c->producto_id, $cliente->id_precio, $venta->tipomoneda_id);
        if (count($extraerdata) > 0) {
            foreach ($extraerdata as $data) {
                $precio = $data->IMPORTE;
            }
        }

        $tipo = TipoProductoData::VerId($product->ID_TIPO_PROD);
        $cant = StockData::vercontenidos($product->id_producto);
        foreach ($cant as $can) {
            $q = $can->CANTIDAD_STOCK;
            $id_dep = $can->DEPOSITO_ID;
        }
        // array_push($result, $product);
        array_push($result, array("precio" => $c->precio, "cambio" => $venta->cambio2, "moneda" => $venta->tipomoneda_id, "cliente" => $venta->cliente_id, "cantidadc" => $c->q, "deposito" => $c->deposito, "depositotext" => $c->deposito_nombre, "cantidad" => $q, "tipo" => $tipo->TIPO_PRODUCTO, "producto" => $product));
    }
}
header("Content-type:application/json");
$jsdata = json_decode(file_get_contents('php://input'), true);
header("HTTP/1.1 200 OK");
header('Content-Type: text/plain');
echo json_encode($result);
