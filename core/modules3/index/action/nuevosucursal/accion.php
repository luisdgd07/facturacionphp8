<?php
$c= SuccursalData::getSucursal($_POST["nombre"]);
  if($c==null){
  $product = new SuccursalData();
foreach ($_POST as $k => $v) {
  $product->$k = $v;
  # code...
}

$_SESSION["registro"]= 1;
$product->registro();
 Core::alert("Registro de empresa con exito...!");
Core::redir("index.php?view=sucursal");
}else{
Core::alert("Esta empresa ya se encuentra Registrada...!");
Core::redir("index.php?view=sucursal");
}
?>