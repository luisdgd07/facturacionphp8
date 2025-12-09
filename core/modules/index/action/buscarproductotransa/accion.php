  <?php
  $result = [];
  $products = ProductoData::getLikee2($_GET['sucursal'], $_GET['buscar']);
  foreach ($products as $product) {
    $extraerdata  = ProductoData::listar_precio_productos($product->id_producto);
    $precio = 0;
    $q = 0;
    if (count($extraerdata) > 0) {
      foreach ($extraerdata as $data) {
        $precio = $data->IMPORTE;
        $datito = ProductoData::vertipomonedadescrip2($_GET['sucursal'], $data->PRECIO_ID);
      }
    }
    $tipo = TipoProductoData::VerId($product->ID_TIPO_PROD) ? TipoProductoData::VerId($product->ID_TIPO_PROD)->TIPO_PRODUCTO : null;
    // $cant = StockData::vercontenidos2($product->id_producto);
    $cant = StockData::vercontenidos3($product->id_producto, $_GET['deposito']);
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
    // var_dump($cant->DEPOSITO_ID);
    // $id_dep = $can->DEPOSITO_ID;
    // }
    $dep = $cant->DEPOSITO_ID ? ProductoData::deposito($cant->DEPOSITO_ID)[0]->NOMBRE_DEPOSITO : null;
    // array_push($result, $product);
    array_push($result, array("cantidad" => $q, "deposito" => $dep, "deposito_id" => $cant->DEPOSITO_ID, "precio" => $precio, "tipo" => $tipo, "producto" => $product));
  }
  header("Content-type:application/json");
  $jsdata = json_decode(file_get_contents('php://input'), true);
  header("HTTP/1.1 200 OK");
  header('Content-Type: text/plain');
  echo json_encode($result);
