<?php

if(!isset($_SESSION["reabastecer"])){


	$product = array("producto_id"=>$_POST["producto_id"],"q"=>$_POST["q"],"precio"=>$_POST["precio"],"stock"=>$_POST["stock"]);
	$_SESSION["reabastecer"] = array($product);


	$cart = $_SESSION["reabastecer"];

///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////

$process=true;


}else {

$found = false;
$cart = $_SESSION["reabastecer"];
$index=0;

$q = OperationData::getQYesFf($_POST["producto_id"]);





$can = true;

?>

<?php
if($can==true){
foreach($cart as $c){
	if($c["producto_id"]==$_POST["producto_id"]){
		echo "found";
		$found=true;
		break;
	}
	$index++;
//	print_r($c);
//	print "<br>";
}

if($found==true){
	$q1 = $cart[$index]["q"];
	$q2 = $_POST["q"];
	$cart[$index]["q"]=$q1+$q2;
	$_SESSION["reabastecer"] = $cart;
}

if($found==false){
    $nc = count($cart);
	$product = array("producto_id"=>$_POST["producto_id"],"q"=>$_POST["q"],"precio"=>$_POST["precio"],"stock"=>$_POST["stock"]);
	$cart[$nc] = $product;
//	print_r($cart);
	$_SESSION["reabastecer"] = $cart;
}

}
}
Core::redir("index.php?view=ajustarstock&id_sucursal=".$_POST["id_sucursal"]);
// print "<script>window.location='index.php?view=ajustarstock';</script>";
// unset($_SESSION["reabastecer"]);

?>