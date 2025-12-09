<?php
$contrato = new ContratoData();
$contrato->cuota = $_POST['cuota'];
$contrato->monto = $_POST['monto'];
$contrato->total = $_POST['total'];
$contrato->entrega = $_POST['entrega'];
$contrato->cliente = $_POST['cliente'];
$contrato->fecha = $_POST['fecha'];
$contrato->inicial = 0;
$contrato->zona = $_POST['zona'];
$contrato->ncontrato = $_POST['datos'];
$contrato->datos = $_POST['datos'];
$contrato->anticipo = $_POST['anticipo'];
$contrato->moneda = $_POST['moneda'];
$contrato->cliente = $_POST['cliente'];
$contrato->descripcion = $_POST['descripcion'];
$contrato->sucursal = $_POST['sucursal'];
$contratoId = $contrato->crear();
// 
$product = new ProductoData();
foreach ($_POST as $k => $v) {
    $product->$k = $v;
}
$q = 1;
$product->cantidad_inicial = $q;
$product->ID_TIPO_PROD = 23;



$product->usuario_id = $_SESSION["admin_id"];
$product->impuesto = 30;
$product->descripcion = $contratoId[1] . '-Ini';
$_SESSION["registro"] = 1;

$product = new ProductoData();


if ($_POST['entrega'] == 0) {
} else {
    //producto entrega inicial
    $q = 1;
    $product->cantidad_inicial = 1;
    $product->ID_TIPO_PROD = 23;
    $product->usuario_id = $_SESSION["admin_id"];
    $product->impuesto = 30;
    $product->descripcion =  $_POST['descripcion'] . ' Entrega Inicial ';
    //$product->codigo =  $_POST['datos'] . '-Ini';
    $product->codigo =  $_POST['datos'] . '';

    //CATEGORIA Y PRODCUTO
    $product->categoria_id = 33;
    $product->marca_id = 97;
    $product->fecha_vencimiento = $_POST['fecha'];

    $product->nombre = $_POST['descripcion'] . ' Entrega Inicial';
    // $product->producto_id = $prod[1];
    $product->precio = $_POST['entrega'];
    $product->accion_id = AccionData::getByName("entrada")->id_accion;
    $product->q = 1;
    $product->venta_id = "NULL";
    $product->is_oficiall = 1;

    $product->sucursal_id = $_POST["sucursal"];
    $product->DEPOSITO_ID = 15;
    $product->MINIMO_STOCK = 0;
    $product->COSTO_COMPRA = 0;
    $product->cuota = 0;
    $product->moneda = $_POST['moneda'];
    $product->contrato = $contratoId[1];
    $product->imagen = null;

    $product->saldo =  $_POST['entrega'];
    $product->cliente_id = $_POST['cliente'];
    $prod = $product->registrar_contrato();
}




$product = new ProductoData();

//producto entrega inicial
$q = 1;
$product->fecha_vencimiento = null;
$product->cantidad_inicial = 1;
$product->ID_TIPO_PROD = 23;
$product->usuario_id = $_SESSION["admin_id"];
$product->impuesto = 30;
$product->descripcion =  $_POST['descripcion'] . ' ';
//$product->codigo =  $_POST['datos'] . '-Ini';
$product->codigo =  $_POST['datos'] . 'P';

//CATEGORIA Y PRODCUTO
$product->categoria_id = 33;
$product->marca_id = 97;

$product->nombre = $_POST['descripcion'] . ' ';
// $product->producto_id = $prod[1];
$product->precio = 0;
$product->accion_id = AccionData::getByName("entrada")->id_accion;
$product->q = 1;
$product->venta_id = "NULL";
$product->is_oficiall = 1;

$product->sucursal_id = $_POST["sucursal"];
$product->DEPOSITO_ID = 15;
$product->MINIMO_STOCK = 0;
$product->COSTO_COMPRA = 0;
$product->cuota = 0;
$product->imagen = null;

$product->moneda = $_POST['moneda'];
$product->contrato = $contratoId[1];

$product->saldo = 0;
$product->cliente_id = "NULL";
$prod = $product->registrar_contrato();







$dias_cre = 0;
$dias_cred = 0;
$nueva_fecha = '';

$dias_cre = ClienteData::getById($_POST['cliente'])->dias_credito;
for ($i = 0; $i < $_POST['cuota']; $i++) {
    $product = new ProductoData();
    $q = 1;
    $product->cantidad_inicial = $q;
    $product->ID_TIPO_PROD = 23;

    //calculo de fecha de vencimiento



    $dias_cred = $dias_cred +  $dias_cre;

    $nueva_fecha = date('Y-m-d', strtotime($_POST['fecha'] . ' +' . $dias_cred . ' days'));

    $product->fecha_vencimiento = $nueva_fecha;

    $product->usuario_id = $_SESSION["admin_id"];
    $product->impuesto = 30;
    $product->descripcion = $_POST['descripcion'] . ' Cuota ' . ($i + 1);
    $product->codigo = $_POST['datos'] . '-Cuota' . ($i + 1);
    $product->nombre = $_POST['descripcion'] . ' Cuota ' . ($i + 1);;
    // $op = new ProductoData();
    // $product->producto_id = $prod[1];
    $product->precio = $_POST['monto'];
    $product->accion_id = AccionData::getByName("entrada")->id_accion;
    $product->q = 1;
    $product->venta_id = "NULL";
    $product->is_oficiall = 1;
    $product->moneda = $_POST['moneda'];

    //CATEGORIA Y PRODCUTO
    $product->categoria_id = 33;
    $product->marca_id = 97;

    $product->sucursal_id = $_POST["sucursal"];
    $product->DEPOSITO_ID = 15;
    $product->MINIMO_STOCK = 0;
    $product->COSTO_COMPRA = 0;
    $product->imagen = null;
    $product->cuota = $i + 1;
    $product->imagen = null;
    $product->contrato = $contratoId[1];
    $product->saldo = $_POST['monto'];
    $product->cliente_id = $_POST['cliente'];
    $prod = $product->registrar_contrato();
    // var_dump($prod);
    // $op->registrar_contrato();
}




//producto final de cuota

if ($_POST['anticipo'] == 0) {
} else {

    $q = 1;
    $product->cantidad_inicial = 1;
    $product->ID_TIPO_PROD = 23;


    $dias_cred = $dias_cred +  $dias_cre;

    $nueva_fecha = date('Y-m-d', strtotime($_POST['fecha'] . ' +' . $dias_cred . ' days'));

    $product->fecha_vencimiento = $nueva_fecha;



    $product->usuario_id = $_SESSION["admin_id"];
    $product->impuesto = 30;
    $product->descripcion =  $_POST['descripcion'] . ' cuota final ';
    $product->codigo =  $_POST['datos'] . '-cuofin';

    //CATEGORIA Y PRODCUTO
    $product->categoria_id = 33;
    $product->marca_id = 97;

    $product->nombre = $_POST['descripcion'] . ' cuota final';
    // $product->producto_id = $prod[1];
    $product->precio = $_POST['anticipo'];
    $product->accion_id = AccionData::getByName("entrada")->id_accion;
    $product->q = 1;
    $product->venta_id = "NULL";
    $product->is_oficiall = 1;

    $product->sucursal_id = $_POST["sucursal"];
    $product->DEPOSITO_ID = 15;
    $product->MINIMO_STOCK = 0;
    $product->COSTO_COMPRA = 0;
    $product->cuota = 0;
    $product->moneda = $_POST['moneda'];
    $product->contrato = $contratoId[1];
    $product->imagen = null;

    $product->saldo =  $_POST['anticipo'];
    $product->cliente_id = $_POST['cliente'];
    $prod = $product->registrar_contrato();
}




Core::alert("Contrato registrado");
$s = $_POST['sucursal'];
Core::redir("index.php?view=nuevocontrato&id_sucursal=$s");
