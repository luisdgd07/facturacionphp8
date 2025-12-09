<?php
$c= CategoriaData::getCategoria($_POST["nombre"]);
  if($c==null){
  $product = new CategoriaData();
foreach ($_POST as $k => $v) {
  $product->$k = $v;
  # code...
}

$_SESSION["registro"]= 1;
$product->nueva_categoria();
Core::alert("CATEGORIA REGISTRADA CORRECTAMENTE...!");
Core::redir("index.php?view=categoria");
}else{
Core::alert("ESTA CATEGORIA YA ESTA REGISTRADA...!");
Core::redir("index.php?view=categoria");
}
?>