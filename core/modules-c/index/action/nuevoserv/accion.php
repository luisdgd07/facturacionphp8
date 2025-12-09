<?php
$c= ProductoData::getNombre($_POST["codigo"], $_POST["id_sucursal"]);


                   if ($_POST["tipo_producto"]==1) {
                          $tipo= "Producto";
						   
                               }
                            if ($_POST["tipo_producto"]==2) {
                            $tipo= "Servicio";
                             }



if($c==null){
  $product = new ProductoData();
  foreach ($_POST as $k => $v) {
    $product->$k = $v;
  }
  $alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
  $imagen = new Upload($_FILES["imagen"]);
  if ($imagen->uploaded) {
    $url="storage/producto/";
    $imagen->Process($url);
    $product->imagen = $imagen->file_dst_name;
  }
  $q= 1;
  $product->cantidad_inicial = $q;
  if ($tipo=="Producto") {
    $product->ID_TIPO_PROD=TipoProductoData::getByName("Producto")->ID_TIPO_PROD;
  }
  if ($tipo=="Servicio") {
    $product->ID_TIPO_PROD=TipoProductoData::getByName("Servicio")->ID_TIPO_PROD;
  }  
  $product->usuario_id = $_SESSION["admin_id"];
  $_SESSION["registro"]= 1;
  $prod=$product->registrar_servicio1();

  if($q!="" || $q!="0")   {
   $op = new OperationData();
   $op->producto_id = $prod[1] ;
   $op->precio=$_POST["precio_venta"];
   $op->accion_id=AccionData::getByName("entrada")->id_accion;
   $op->q= 1;
   $op->venta_id="NULL";
   $op->is_oficiall=1;

   $op->SUCURSAL_ID= $_POST["id_sucursal"];
   $op->DEPOSITO_ID= 0;
   $op->MINIMO_STOCK= 0;
   $op->DEPOSITO_ID= 0;

   $op->COSTO_COMPRA= 0;

   $op->registro_producto();

   
   if ($tipo=="Servicio") {
     $registro2 = new StockData();
     $registro2->DEPOSITO_ID =0;
     $registro2->PRODUCTO_ID=$prod[1];
     $registro2->CANTIDAD_STOCK=1;
     $registro2->MINIMO_STOCK = 0;
     $registro2->MAXIMO_STOCK = 0;
     $registro2->SUCURSAL_ID=$_POST['sucursal_id'];
     $registro2->COSTO_COMPRA=0;
     $registro2->registrar();
   }
   
  }
 Core::alert("SERVICIO REGISTRADO CON EXITO...!");
Core::redir("index.php?view=nuevoservicio&id_sucursal=".$_POST["id_sucursal"]);
}else{
  Core::alert("ESTE SERVICIO YA SE ENCUENTRA REGISTRADO...!");
  Core::redir("index.php?view=nuevoservicio&id_sucursal=".$_POST["id_sucursal"]);
}
?>