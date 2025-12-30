<?php
$product = new CajaData();
// PHP 8.4 compatible: Explicitly set properties instead of dynamic assignment
foreach ($_POST as $k => $v) {
  if (property_exists($product, $k)) {
    $product->$k = $v;
  }
}
$product->fecha = date("Y-m-d");
$product->aperturaporusuario();
Core::redir("index.php?view=cajausuario&id_usuario=" . $_POST["id_usuario"] . "&" . "id_sucursal=" . $_POST["id_sucursal"]);
// Core::redir("index.php?view=cajausuario&id_sucursal=".$_GET["id_sucursal"]);

?>