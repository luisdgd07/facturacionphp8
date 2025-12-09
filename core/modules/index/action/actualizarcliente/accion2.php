<?php
// print_r($_POST);
$cliente =  new ClienteData();
foreach ($_POST as $k => $v) {
	$cliente->$k = $v;
	# code...
}
$handle = new Upload($_FILES['imagen']);
if ($handle->uploaded) {
	$url = "storage/cliente/";
	$handle->Process($url);

	$cliente->imagen = $handle->file_dst_name;
	$cliente->actualizar_imagen();
}
if (isset($_POST["is_publico"])) {
	$cliente->is_publico = 1;
} else {
	$cliente->is_publico = 0;
}
// if(isset($_POST["is_admin"])) { $cliente->is_admin=1; }else{ $cliente->is_admin=0; }
if (isset($_POST["is_activo"])) {
	$cliente->is_activo = 1;
} else {
	$cliente->is_activo = 0;
}
if (isset($_POST["is_proveedor"])) {
	$cliente->is_proveedor = 1;
} else {
	$cliente->is_proveedor = 0;
}


$sql = $cliente->actualizar_cliente();
echo $sql;
$_SESSION["actualizar_datos"] = 1;
core::alert("Registro del cliente actualizado correctamente");

//  Core::redir("index.php?view=cliente&id_sucursal=".$_POST["id_sucursal"]);
//Core::redir("index.php?view=actualizarcliente&id_cliente=" . $_POST["id_cliente"]);