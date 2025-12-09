<?php
$c= GrupoData::getgrupo($_POST["nombre"],$_POST["id_sucursal"]);
  if($c==null){
  $product = new GrupoData();
foreach ($_POST as $k => $v) {
  $product->$k = $v;
  # code...
}
$a= $_POST["sucursal"];
$b= $_POST["nombre"];
$product->nombre= $b;
$_SESSION["registro"]= 1;
$product->nuevo_grupo();
Core::alert("GRUPO REGISTRADO CORRECTAMENTE...!");
Core::redir("index.php?view=grupos&id_sucursal=".$_POST["id_sucursal"]);
}else{
Core::alert("ESTE GRUPO YA SE ENCUENTRA REGISTRADA...!");
Core::redir("index.php?view=grupos&id_sucursal=".$_POST["id_sucursal"]);
}
?>