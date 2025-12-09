<?php

$pass = sha1(md5($_POST['password']));
$user = $_POST['usuario'];

$base = new Database();
$con = $base->connect();
$sql = "select * from usuario where  usuario= \"" . $user . "\" and password= \"" . $pass . "\"";
//print $sql;
$query = $con->query($sql);
$found = false;
$userid = null;
while ($r = $query->fetch_array()) {
	$found = true;
	$userid = $r['id_usuario'];
}
if ($found == true) {
	echo 1;
	//	session_start();
	//	print $userid;
	//	setcookie('userid',$userid);
	//	print $_SESSION['userid'];
	// print "Cargando ... $user";
	// print "<script>window.location='index.php?view=index';</script>";
} else {
	echo 0;
	// Core::alert("Usuario o Password Incorrecta.   ! Vuelva a intentarlo ");
}
