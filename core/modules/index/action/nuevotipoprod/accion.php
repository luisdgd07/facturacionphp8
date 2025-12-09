<?php
$c= ProductoData::gettipoprod($_POST["descripcion"], $_POST["id_sucursal"]);
  if($c==null){
  $product = new ProductoData();
foreach ($_POST as $k => $v) {
  $product->$k = $v;
  # code...
}
$a= $_POST["id_sucursal"];
$b= $_POST["descripcion"];
$product->sucursal_id= $a;
$product->TIPO_PRODUCTO= $b;
$_SESSION["registro"]= 1;
$product->registrotipo();
 Core::alert("TIPO PRODUCTO REGISTRADO CORRECTAMENTE!");
Core::redir("index.php?view=tipo_producto&id_sucursal=".$_POST["id_sucursal"]);
}else{
Core::alert("EL TIPO PRODUCTO YA SE ENCUENTRA REGISTRADA...!");
Core::redir("index.php?view=tipo_producto&id_sucursal=".$_POST["id_sucursal"]);
}
?>