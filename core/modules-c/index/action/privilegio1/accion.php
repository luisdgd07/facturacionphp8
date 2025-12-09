<?php
// print_r($_POST);
$cliente =  new Userdata();
foreach ($_POST as $k => $v) {
	$cliente->$k = $v;
	# code...
}


if(isset($_POST["is_activo"])) { $cliente->is_activo=1; }else{ $cliente->is_activo=0; }
if(isset($_POST["is_admin"])) { $cliente->is_admin=1; }else{ $cliente->is_admin=0; }
if(isset($_POST["is_publico"])) { $cliente->is_publico=1; }else{ $cliente->is_publico=0; }
 $cliente->actualizar_pivilegio();
$_SESSION["actualizar_datos"]= 1;
Core::alert("Información Actualizada...!");
Core::redir("index.php?view=actualizaradministrador&id_usuario=".$_POST["id_usuario"]);

?>