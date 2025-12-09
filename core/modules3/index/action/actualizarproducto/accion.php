<?php
$empleado =  new ProductoData();
foreach ($_POST as $k => $v) {
	$empleado->$k = $v;
	# code...
}
$handle = new Upload($_FILES['imagen']);
if ($handle->uploaded) {
	$url="storage/producto/";
	$handle->Process($url);

    $empleado->imagen = $handle->file_dst_name;
    $empleado->actualizar_imagen();
}
if(isset($_POST["activo"])) { $empleado->activo=1; }else{ $empleado->activo=0; }
 $empleado->actualizar_Producto();
$_SESSION["actualizar_datos"]= 1;
Core::redir("index.php?view=actualizarproducto&id_producto=".$_POST["id_producto"]);

?>