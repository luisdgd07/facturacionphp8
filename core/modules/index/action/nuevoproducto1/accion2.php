<?php
$c = ProductoData::getNombre($_POST["codigo"], $_POST["id_sucursal"]);
$tipo = $_POST["tipo_producto"];
if ($c == null) {
  $product = new ProductoData();
  foreach ($_POST as $k => $v) {
    $product->$k = $v;
  }
  $alphabeth = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
  if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == UPLOAD_ERR_OK) {
    $imagen_tmp = $_FILES["imagen"]["tmp_name"];
    $extension = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
    $nombre_imagen = uniqid() . "." . $extension;
    $url = "storage/producto/" . $nombre_imagen;
    if (move_uploaded_file($imagen_tmp, $url)) {
      $product->imagen = $nombre_imagen;
    }
  }

  $q = $_POST["q"];
  $product->cantidad_inicial = $q;
  if ($tipo == "Producto") {
    $product->ID_TIPO_PROD = TipoProductoData::getByName("Producto")->ID_TIPO_PROD;
  }
  if ($tipo == "Servicio") {
    $product->ID_TIPO_PROD = TipoProductoData::getByName("Servicio")->ID_TIPO_PROD;
  }
  if ($tipo == "Insumo") {
    $product->ID_TIPO_PROD = TipoProductoData::getByName("Insumo")->ID_TIPO_PROD;
  }
  $product->usuario_id = $_SESSION["admin_id"];
  $product->impuesto = $_POST["impuesto"];
  $product->descripcion = $_POST["descripcion"];
  $_SESSION["registro"] = 1;
  $prod = $product->registrar_producto1();
  var_dump($prod);
  if ($_POST["q"] != "" || $_POST["q"] != "0") {
    $op = new OperationData();
    $op->producto_id = $prod[1];
    $op->precio = $_POST["precio_venta"];
    $op->accion_id = AccionData::getByName("entrada")->id_accion;
    $op->q = $_POST["q"];
    $op->venta_id = "NULL";
    $op->is_oficiall = 1;

    $op->SUCURSAL_ID = $_POST["id_sucursal"];
    $op->DEPOSITO_ID = $_POST["id_deposito"];
    $op->MINIMO_STOCK = $_POST["inventario_minimo"];
    $op->DEPOSITO_ID = $_POST["inventario_maximo"];

    $op->COSTO_COMPRA = $_POST["precio_compra"];

    $idProd =  $op->registro_producto();


    if ($tipo == "Producto") {
      $registro2 = new StockData();
      $registro2->DEPOSITO_ID = $_POST['id_deposito'];
      $registro2->PRODUCTO_ID = $prod[1];
      $registro2->CANTIDAD_STOCK = $_POST['q'];
      $registro2->MINIMO_STOCK = $_POST['inventario_minimo'];
      $registro2->MAXIMO_STOCK = $_POST['inventario_maximo'];
      $registro2->SUCURSAL_ID = $_POST['id_sucursal'];
      $registro2->COSTO_COMPRA = $_POST['precio_compra'];
      $registro2->registrar();
    }
  }
  $cart =  json_decode($_POST['carrito']);
  // var_dump($cart);

  foreach ($cart as $c) {
    $insumos = new InsumosData();
    $insumos->producto_id = $prod[1];
    $insumos->nombre = $c->producto;
    $insumos->insumo_id = $c->id;
    $insumos->cantidad = $c->cantidad;
    $insumos->precio = $c->precio;
    $insumos->total = $c->total;
    $insumos->id_sucursal = $_POST["id_sucursal"];
    $insu = $insumos->registrarnuevo();
    // var_dump($insu);
  }
  header("Content-type:application/json");
  $jsdata = json_decode(file_get_contents('php://input'), true);
  header("HTTP/1.1 200 OK");
  header('Content-Type: text/plain');
  echo 1;
} else {
  header("Content-type:application/json");
  $jsdata = json_decode(file_get_contents('php://input'), true);
  header("HTTP/1.1 200 OK");
  header('Content-Type: text/plain');
  echo -1;
}
