<?php

$category = CategoriaData::getById($_GET["id_categoria"]);
$products = ProductoData::getAllByCategoriaId($category->id_categoria);
foreach ($products as $product) {
	$product->del_categoria();
}

$category->del();
Core::redir("./index.php?view=categoria");


?>