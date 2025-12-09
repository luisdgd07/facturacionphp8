<?php 
$a=$_POST["cash"];
$b=$_POST["adelanto"];
$resultado=$a+$b;
$total=$_POST["total"];
if ($resultado==$total) {
	$registrar=new VentaData();
 foreach ($_POST as $k => $v) {
  $registrar->$k = $v;
	}

	$registrar->cash=$b+$a;
	$registrar->pagado=1;
	$registrar->registrarcobranza();
}
else {
	 $registrar=new VentaData();
 foreach ($_POST as $k => $v) {
  $registrar->$k = $v;
	}

	$registrar->cash=$b+$a;
	if(isset($_POST["pagado"])) { $registrar->pagado=1; }else{ $registrar->pagado=0; }
	$registrar->registrarcobranza();
}
Core::redir("index.php?view=pagardeuda&id_sucursal=".$_POST["id_sucursal"]);
 ?>