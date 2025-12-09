<?php
$c= CategoriaData::getCategoria($_POST["nombre"],$_POST["id_sucursal"]);
  if($c==null){
  $product = new CategoriaData();
foreach ($_POST as $k => $v) {
  $product->$k = $v;
  # code...
}
$a= $_POST["sucursal"];
$b= $_POST["nombre"];
$product->nombre= $b;
$_SESSION["registro"]= 1;
$product->nueva_categoria1();
Core::alert("CATEGORIA REGISTRADA CORRECTAMENTE...!");
Core::redir("index.php?view=categoria&id_sucursal=".$_POST["id_sucursal"]);
}else{
Core::alert("ESTA CATEGORIA YA SE ENCUENTRA REGISTRADA...!");
Core::redir("index.php?view=categoria&id_sucursal=".$_POST["id_sucursal"]);
}
?>