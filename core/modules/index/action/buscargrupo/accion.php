<?php
$products = ProductoData::getByGrupo($_GET['id'], $_GET['sucursal']);
echo json_encode($products);
