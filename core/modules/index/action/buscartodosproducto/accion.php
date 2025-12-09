  <?php
  $result = [];
  $products = ProductoData::obtenerTodos($_GET['sucursal'], $_GET['buscar'], $_GET['offset']);
  $pages = ProductoData::getpages($_GET['sucursal'], $_GET['buscar']);
  foreach ($products as $product) {

    $tipo = TipoProductoData::VerId($product->ID_TIPO_PROD);


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
    array_push($result, $product);
  }
  header("Content-type:application/json");
  $jsdata = json_decode(file_get_contents('php://input'), true);
  header("HTTP/1.1 200 OK");
  header('Content-Type: text/plain');
  echo json_encode([
    "result" =>  $result,
    "pages" => ceil($pages[0]->total_registros / 10)
  ]);
