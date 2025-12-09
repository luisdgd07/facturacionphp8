<?php
$c= MarcaData::getCategoria($_POST["nombre"], $_POST["id_sucursal"]);
  if($c==null){
  $product = new MarcaData();
foreach ($_POST as $k => $v) {
  $product->$k = $v;
  # code...
}
$a= $_POST["sucursal"];
$b= $_POST["nombre"];
$product->nombre= $b;
$_SESSION["registro"]= 1;
$product->registro();
 Core::alert("MARCA REGISTRADA CORRECTAMENTE!");
Core::redir("index.php?view=marca&id_sucursal=".$_POST["id_sucursal"]);
}else{
Core::alert("ESTA MARCA YA SE ENCUENTRA REGISTRADA...!");
Core::redir("index.php?view=marca&id_sucursal=".$_POST["id_sucursal"]);
}
?>