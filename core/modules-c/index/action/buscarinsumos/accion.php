  <?php
  // $result = [];
  // $products = ProductoData::getLikee($_GET['sucursal'], $_GET['buscar']);
  // foreach ($products as $product) {
  //   $extraerdata  = ProductoData::listar_precio_productos2($product->id_producto, $_GET['tipocliente'], $_GET['moneda']);
  //   $precio = 0;
  //   $q = 0;
  //   if (count($extraerdata) > 0) {
  //     foreach ($extraerdata as $data) {
  //       $precio = $data->IMPORTE;
  //       $datito = ProductoData::vertipomonedadescrip2($_GET['sucursal'], $data->PRECIO_ID);
  //     }
  //   }
  //   $tipo = TipoProductoData::VerId($product->ID_TIPO_PROD);
  //   $cant = StockData::vercontenidos2($product->id_producto);
  //   foreach ($cant as $can) {
  //     $q = $can->CANTIDAD_STOCK;
  //     $id_dep = $can->DEPOSITO_ID;
  //   }
  //   // array_push($result, $product);
  //   array_push($result, array("cantidad" => $q, "precio" => $precio, "tipo" => $tipo->TIPO_PRODUCTO, "producto" => $product));
  // }
  // header("Content-type:application/json");
  // $jsdata = json_decode(file_get_contents('php://input'), true);
  // header("HTTP/1.1 200 OK");
  // header('Content-Type: text/plain');
  // echo json_encode($result);

  $result = [];
  $tipo = ProductoData::verinsumo($_GET['sucursal']);
  $products = ProductoData::getInsumo($_GET['sucursal'], $_GET['buscar'],  $tipo->ID_TIPO_PROD);
  foreach ($products as $product) {
    $precio = 0;
    $q = 0;
    $tipo = TipoProductoData::VerId($product->ID_TIPO_PROD);
    // foreach ($cant as $can) {
    // var_dump($cant);
    // $q = 0;
    // var_dump($can->CANTIDAD_STOCK);
    // $id_dep = $can->DEPOSITO_ID;
    // }
    // array_push($result, $product);
    array_push($result, array("cantidad" => $q, "tipo" => $tipo->TIPO_PRODUCTO, "producto" => $product));
  }
  header("Content-type:application/json");
  $jsdata = json_decode(file_get_contents('php://input'), true);
  header("HTTP/1.1 200 OK");
  header('Content-Type: text/plain');
  echo json_encode($result);
