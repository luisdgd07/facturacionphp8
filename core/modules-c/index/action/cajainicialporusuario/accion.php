<?php
$product = new CajaData();
foreach ($_POST as $k => $v) {
  $product->$k = $v;
}

$product->aperturaporusuario();
Core::redir("index.php?view=cajausuario&id_usuario=".$_POST["id_usuario"]."&"."id_sucursal=".$_POST["id_sucursal"]);
// Core::redir("index.php?view=cajausuario&id_sucursal=".$_GET["id_sucursal"]);

?>