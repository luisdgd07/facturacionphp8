<?php


if(isset($_SESSION["admin_id"])){
	$user = UserData::getById($_SESSION["admin_id"]);
	$user->nombre = $_POST["nombre"];
	$user->apellido = $_POST["apellido"];
	$user->dni = $_POST["dni"];
	$user->telefono = $_POST["telefono"];
	$user->direccion = $_POST["direccion"];
	$user->genero = $_POST["genero"];
	$user->actulizar_datos();
	setcookie("password_updated","true");
	print "<script>alert('Actualizado Exitosamente!');window.location='index.php?view=actualizarperfil';</script>";

}else {
		print "<script>window.location='index.php';</script>";
}

?>