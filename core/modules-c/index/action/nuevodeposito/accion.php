<?php
$c= ProductoData::getdeposito($_POST["descripcion"], $_POST["id_sucursal"]);
  if($c==null){
  $product = new ProductoData();
foreach ($_POST as $k => $v) {
  $product->$k = $v;
  # code...
}
$a= $_POST["id_sucursal"];
$b= $_POST["descripcion"];
$product->sucursal_id= $a;
$product->NOMBRE_DEPOSITO= $b;
$_SESSION["registro"]= 1;
$product->registrodeposito();
 Core::alert("DEPOSITO REGISTRADO CORRECTAMENTE!");
Core::redir("index.php?view=deposito&id_sucursal=".$_POST["id_sucursal"]);
}else{
Core::alert("EL DEPOSITO YA SE ENCUENTRA REGISTRADO...!");
Core::redir("index.php?view=deposito&id_sucursal=".$_POST["id_sucursal"]);
}
?>