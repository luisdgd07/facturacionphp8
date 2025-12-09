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
  $products = ProductoData::getLikee($_GET['sucursal'], $_GET['buscar'], $tipo->ID_TIPO_PROD);
  foreach ($products as $product) {
    $extraerdata  = ProductoData::listar_precio_productos2($product->id_producto, $_GET['tipocliente'], $_GET['moneda']);
    $precio = 0;
    $q = 0;
    if (count($extraerdata) > 0) {
      foreach ($extraerdata as $data) {
        $precio = $data->IMPORTE;
        $datito = ProductoData::vertipomonedadescrip2($_GET['sucursal'], $data->PRECIO_ID);
      }
    }
    $tipo = TipoProductoData::VerId($product->ID_TIPO_PROD);
    $cant = StockData::vercontenidos3($product->id_producto, $_GET['deposito']);
    // foreach ($cant as $can) {
    // var_dump($cant);
    if (isset($cant)) {
      $q = $cant->CANTIDAD_STOCK;
    } else {
      $q = 0;
      $stock = new StockData();
      $stock->PRODUCTO_ID = $product->id_producto;
      $stock->DEPOSITO_ID = $_GET['deposito'];
      $stock->CANTIDAD_STOCK = 0;
      $stock->MINIMO_STOCK = 0;
      $stock->MAXIMO_STOCK = 0;
      $stock->COSTO_COMPRA = 0;
      $stock->SUCURSAL_ID = $_GET['sucursal'];
      // $this->DEPOSITO_ID,$this->PRODUCTO_ID,$this->CANTIDAD_STOCK,$this->MINIMO_STOCK,$this->MAXIMO_STOCK,$this->SUCURSAL_ID,$this->COSTO_COMPRA
      $st = $stock->registrar();
    }
    // $q = 0;
    // var_dump($can->CANTIDAD_STOCK);
    // $id_dep = $can->DEPOSITO_ID;
    // }
    // array_push($result, $product);
    if ($tipo->TIPO_PRODUCTO == "Contrato") {
    } else {
      array_push($result, array("cantidad" => $q, "precio" => $precio, "tipo" => $tipo->TIPO_PRODUCTO, "producto" => $product));
    }
  }
  header("Content-type:application/json");
  $jsdata = json_decode(file_get_contents('php://input'), true);
  header("HTTP/1.1 200 OK");
  header('Content-Type: text/plain');
  echo json_encode($result);
