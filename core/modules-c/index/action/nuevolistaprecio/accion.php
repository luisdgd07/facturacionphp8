<?php



$descripcion2 = ProductoData::vertipomonedadescrip($_POST["id_sucursal"], $_POST["moneda_id"] );
						
						
						foreach($descripcion2 as $descripcionnom){
						  
						  $descripm=$descripcionnom->nombre;
						
						  }




$c= ProductoData::getlistadopre($_POST["descripcion"], $_POST["id_sucursal"]);
  if($c==null){
  $product = new ProductoData();
foreach ($_POST as $k => $v) {
  $product->$k = $v;
  # code...
}
$a= $_POST["id_sucursal"];
$b= $_POST["descripcion"];
$product->sucursal_id= $a;
$product->nombre= $b;
$product->moneda_non= $descripm;


$_SESSION["registro"]= 1;
$product->registrolistaprecio();
 Core::alert("LISTA DE PRECIO REGISTRADO CORRECTAMENTE!");
Core::redir("index.php?view=lista_precio&id_sucursal=".$_POST["id_sucursal"]);
}else{
Core::alert("LISTA DE PRECIO YA SE ENCUENTRA REGISTRADO...!");
Core::redir("index.php?view=lista_precio&id_sucursal=".$_POST["id_sucursal"]);
}
?>