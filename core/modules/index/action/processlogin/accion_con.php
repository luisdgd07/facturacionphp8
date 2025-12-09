<?php

// define('LBROOT',getcwd()); // LegoBox Root ... the server root
// include("core/controller/Database.php");





if ($_POST['g-recaptcha-response'] == '') {
header("Location: index.php?alert=3");
} else {
$obj = new stdClass();
$obj->secret = "6LcdipMbAAAAAJ0R4eRtpozBR_CQUmjNxglhxtzp";
$obj->response = $_POST['g-recaptcha-response'];
$obj->remoteip = $_SERVER['REMOTE_ADDR'];
$url = 'https://www.google.com/recaptcha/api/siteverify';

$options = array(
'http' => array(
'header' => "Content-type: application/x-www-form-urlencoded\r\n",
'method' => 'POST',
'content' => http_build_query($obj)
)
);
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

$validar = json_decode($result);

/* FIN DE CAPTCHA */



	
	
	

if ($validar->success) {



if(!isset($_SESSION["admin_id"])) {
$user = $_POST['email'];
$pass = sha1(md5($_POST['password']));

$base = new Database();
$con = $base->connect();
 $sql = "select * from usuario where (email= \"".$user."\" or usuario= \"".$user."\") and password= \"".$pass."\" and is_activo=1";
//print $sql;
$query = $con->query($sql);
$found = false;
$userid = null;
while($r = $query->fetch_array()){
	$found = true ;
	$userid = $r['id_usuario'];
}

if($found==true) {
//	session_start();
//	print $userid;
	$_SESSION['admin_id']=$userid ;
//	setcookie('userid',$userid);
//	print $_SESSION['userid'];
	print "Cargando ... $user";
	// Core::alert( "El sistema de ! ONLIBO ! le da la Bienvenida.   ! $user !");
	print "<script>window.location='index.php?view=index';</script>";
}else {
	Core::alert( "Usuario o Password Incorrecta.   ! Vuelva a intentarlo ");
	print "<script>window.location='index.php?view=login';</script>";
}

}else{
	print "<script>window.location='index.php?view=index';</script>";
	
}

} 

else {
	
Core::alert( "Capacha incorrecto vuelta a intentarlo!!! ");
	print "<script>window.location='index.php?view=login';</script>";
}
}

?>