<?php



$id_producto= $_POST["id_producto"];


$descripcion1 = ProductoData::vertipomonedadescrip3($_POST["id_sucursal"], $id_producto );
						
						
						foreach($descripcion1 as $descripciop){
						  
					
						  
						   $NOMBRE_p= $descripciop->nombre;
                            	
						
						  }


$id_precio= $_POST["id_precio"];

$descripcion2 = ProductoData::vertipomonedadescrip2($_POST["id_sucursal"], $id_precio );
						
						
						foreach($descripcion2 as $descripcionnom){
						  
					
						  
						   $NOMBRE_MONE= $descripcionnom->NOMBRE_MONEDA;
                             $moneda_id= $descripcionnom->MONEDA_ID;	
						
						  }




$c= ProductoData::getlistadoprecio_pro($_POST["id_precio"], $_POST["id_producto"], $_POST["id_sucursal"], $_POST["importe_precio"]  );
  if($c==null){
  $product = new ProductoData();
foreach ($_POST as $k => $v) {
  $product->$k = $v;
  # code...
}
$a= $_POST["id_sucursal"];

$product->sucursal_id= $a;


$product->moneda_non= $NOMBRE_MONE;
$product->id_moneda= $moneda_id;
$product->nombre_prod= $NOMBRE_p;





$_SESSION["registro"]= 1;
$product->registrolistaprecio_pro();
 Core::alert("LISTA DE PRECIO DE PRODUCTO REGISTRADO CORRECTAMENTE!");
Core::redir("index.php?view=producto_precio&id_sucursal=".$_POST["id_sucursal"]);
}else{
Core::alert("LISTA DE PRECIO DE PRODUCTO YA SE ENCUENTRA REGISTRADO...!");
Core::redir("index.php?view=producto_precio&id_sucursal=".$_POST["id_sucursal"]);
}
?>