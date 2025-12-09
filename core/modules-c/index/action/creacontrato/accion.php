<?php
$contrato = new ContratoData();
$contrato->cuota = $_POST['cuota'];
$contrato->monto = $_POST['monto'];
$contrato->total = $_POST['total'];
$contrato->entrega = $_POST['entrega'];
$contrato->cliente = $_POST['cliente'];
$contrato->fecha = $_POST['fecha'];
$contrato->inicial = $_POST['inicial'];
$contrato->zona = $_POST['zona'];
$contrato->ncontrato = $_POST['datos'];
$contrato->datos = $_POST['datos'];
$contrato->cliente = $_POST['cliente'];
$contrato->descripcion = $_POST['descripcion'];
$contrato->sucursal = $_POST['sucursal'];
$contratoId = $contrato->crear();
// 
$tipo = $_POST["tipo_producto"];
$product = new ProductoData();
foreach ($_POST as $k => $v) {
    $product->$k = $v;
}
$q = 1;
$product->cantidad_inicial = $q;
$product->ID_TIPO_PROD = TipoProductoData::getByName("Contrato")->ID_TIPO_PROD;
$product->usuario_id = $_SESSION["admin_id"];
$product->impuesto = 30;
$product->descripcion = 'Con' . $contratoId[1] . '-Inicial';
$_SESSION["registro"] = 1;
$opi = new ProductoData();
$product->producto_id = $prod[1];
$product->precio = $_POST['inicial'];
$product->nombre = $_POST['descripcion'] . ' Entrega Inicial';
$product->accion_id = AccionData::getByName("entrada")->id_accion;
$product->q = 1;
$product->venta_id = "NULL";
$product->is_oficiall = 1;
$product->SUCURSAL_ID = $_POST["id_sucursal"];
$product->DEPOSITO_ID = 5;
$product->MINIMO_STOCK = 0;
$product->COSTO_COMPRA = 0;
$product->cliente_id = $_POST['cliente'];
$product->cuota = 0;

$product->codigo = 'Con' . $contratoId[1] . '-Inicial';
$product->precio = $_POST['inicial'];
$product->contrato = $contratoId[1];
$product->saldo = $_POST['inicial'];
$prod = $product->registrar_contrato();
// $opi->registrar_contrato();
for ($i = 0; $i < $_POST['cuota']; $i++) {
    $product = new ProductoData();
    foreach ($_POST as $k => $v) {
        $product->$k = $v;
    }
    $q = 1;
    $product->cantidad_inicial = $q;
    $product->ID_TIPO_PROD = TipoProductoData::getByName("Contrato")->ID_TIPO_PROD;
    $product->usuario_id = $_SESSION["admin_id"];
    $product->impuesto = 30;
    $product->descripcion = 'Con' . $contratoId[1] . ' Cuota ' . ($i + 1);
    $product->codigo = 'Con' . $contratoId[1] . '-Cuota' . ($i + 1);
    $product->nombre = $_POST['descripcion'] . ' Cuota ' . ($i + 1);;
    // $op = new ProductoData();
    $product->producto_id = $prod[1];
    $product->precio = $_POST['monto'];
    $product->accion_id = AccionData::getByName("entrada")->id_accion;
    $product->q = 1;
    $product->venta_id = "NULL";
    $product->is_oficiall = 1;

    $product->SUCURSAL_ID = $_POST["id_sucursal"];
    $product->DEPOSITO_ID = 5;
    $product->MINIMO_STOCK = 0;
    $product->COSTO_COMPRA = 0;
    $product->cuota = $i + 1;

    $product->contrato = $contratoId[1];
    $product->saldo = $_POST['monto'];
    $product->cliente_id = $_POST['cliente'];
    $prod = $product->registrar_contrato();
    // var_dump($prod);
    // $op->registrar_contrato();
}







Core::alert("Contrato registrado");
$s = $_POST['sucursal'];
Core::redir("index.php?view=nuevocontrato&id_sucursal=$s");
