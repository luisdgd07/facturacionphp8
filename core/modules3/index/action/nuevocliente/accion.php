<?php
$c = ClienteData::getBDni($_POST["dni"], $_POST["id_sucursal"]);
// if(count($_POST)>0){
if ($c == null) {
  // $is_active=0;
  // if(isset($_POST["is_active"])){$is_active=1;}
  $product = new ClienteData();
  foreach ($_POST as $k => $v) {
    $product->$k = $v;
    # code...
  }
  $alphabeth = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
  $imagen = new Upload($_FILES["imagen"]);
  if ($imagen->uploaded) {
    $url = "storage/cliente/";
    $imagen->Process($url);

    $product->imagen = $imagen->file_dst_name;
    // $product->registrar_imagen();
  }

  //$a= $_POST["sucursal"];
  $b = $_POST["nombre"];
  $product->nombre = $b;
  $_SESSION["registro"] = 1;
  $product->registrar_cliente();
  Core::alert("Cliente registrado correctamente...!");

  Core::redir("index.php?view=cliente&id_sucursal=" . $_POST["id_sucursal"]);
} else {
  Core::alert("Este Cliente ya se encuentra Registrado...!");


  Core::redir("index.php?view=cliente&id_sucursal=" . $_POST["id_sucursal"]);
}
