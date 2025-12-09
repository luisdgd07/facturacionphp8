  <?php
  $result = [];
  $tipo = ProductoData::verinsumo($_GET['sucursal']);
  $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
  $products = ProductoData::getProducto($_GET['sucursal'], $_GET['buscar'], $_GET['offset'], $limit);
  $pages = ProductoData::getProductoPages($_GET['sucursal'], $_GET['buscar']);
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
    $tipo = TipoProductoData::VerId($product->ID_TIPO_PROD) ?? null;
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
      $st = $stock->registrar();
    }

    $insumosData = new InsumosData();
    $insumos = $insumosData->find($product->id_producto);
    foreach ($insumos as $insumo) {
      $cant2 = StockData::vercontenidos3($insumo->insumo_id, $_GET['deposito']);
      // var_dump($cant2);
      if (isset($cant2)) {
        // $q = $cant->CANTIDAD_STOCK;
        $insumo->disponible = $cant2->CANTIDAD_STOCK;
      }
    }
    array_push($result, array("cantidad" => $q, "precio" => $precio, "tipo" => $tipo->TIPO_PRODUCTO ?? null, "producto" => $product, "insumos" => $insumos,));
  }
  header("Content-type:application/json");
  $jsdata = json_decode(file_get_contents('php://input'), true);
  header("HTTP/1.1 200 OK");
  header('Content-Type: text/plain');
  echo json_encode([
    "result" =>  $result,
    "pages" => ceil($pages[0]->total_registros / max(1, $limit))
  ]);
