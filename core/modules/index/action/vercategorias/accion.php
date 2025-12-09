 <?php
   if ($_GET['categoria'] == 'todos') {
      $products = ProductoData::verproductosucursal($_GET['sucursal']);
      echo json_encode($products);
   } else {
      $products = ProductoData::getAllByCategoriaId($_GET['categoria']);
      echo json_encode($products);
   }
