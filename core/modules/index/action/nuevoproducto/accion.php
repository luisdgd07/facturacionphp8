<?php
$c = ProductoData::getNombre($_POST["nombre"]);
// if(count($_POST)>0){
if ($c == null) {
  // $is_active=0;
  // if(isset($_POST["is_active"])){$is_active=1;}
  $product = new ProductoData();
  foreach ($_POST as $k => $v) {
    $product->$k = $v;
    # code...
  }
  $alphabeth = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
  $imagen = new Upload($_FILES["imagen"]);
  if ($imagen->uploaded) {
    $url = "storage/producto/";
    $imagen->Process($url);

    $product->imagen = $imagen->file_dst_name;
    // $product->registrar_imagen();
  }
  $q = $_POST["q"];
  $product->cantidad_inicial = $q;
  $product->usuario_id = $_SESSION["admin_id"];
  $_SESSION["registro"] = 1;
  $prod = $product->registrar_producto();

  if ($_POST["q"] != "" || $_POST["q"] != "0") {
    $op = new OperationData();
    $op->producto_id = $prod[1];
    $op->accion_id = AccionData::getByName("entrada")->id_accion;
    $op->q = $_POST["q"];
    $op->venta_id = "NULL";
    $op->is_oficiall = 1;
    $op->registro_producto();
  }
  Core::alert("Se Registro de manera Éxistosa...!");
  // Core::redir("index.php?view=registroproducto");
} else {
  Core::alert("Este Producto ya se encuentra Registrado...!");
  Core::redir("index.php?view=producto");
}
