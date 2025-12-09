<?php

if(!isset($_SESSION["cart"])){


	$product = array("producto_id"=>$_POST["producto_id"],"q"=>$_POST["q"]);
	$_SESSION["cart"] = array($product);


	$cart = $_SESSION["cart"];

///////////////////////////////////////////////////////////////////
		$num_succ = 0;
		$process=false;
		$errors = array();
		foreach($cart as $c){

			///
			//$q = OperationData::getQYesFf($c["producto_id"]);
			
			$cant  = StockData::vercontenidos($c["producto_id"]);
	      foreach($cant as $can){
	     $q=$can->CANTIDAD_STOCK;
	         }
			
			
//			echo ">>".$q;
			if(($c["q"]>=$q)  or ($c["q"]<=$q)) {
				$num_succ++;


			}else{
				//$error = array("producto_id"=>$c["producto_id"],"message"=>"No hay suficiente cantidad de producto en inventario.");
				//$errors[count($errors)] = $error;
			}

		}
///////////////////////////////////////////////////////////////////

//echo $num_succ;
if($num_succ==count($cart)){
	$process = true;
}
if($process==false){
	unset($_SESSION["cart"]);
$_SESSION["errors"] = $errors;
	?>	
<script>
	window.location="index.php?view=transacciones&id_sucursal=".$_POST["id_sucursal"];
</script>
<?php
}




}else {

$found = false;
$cart = $_SESSION["cart"];
$index=0;

//$q = OperationData::getQYesFf($_POST["producto_id"]);

$cant  = StockData::vercontenidos($_POST["producto_id"]);
	      foreach($cant as $can){
	     $q=$can->CANTIDAD_STOCK;
	         }



$can = true;
if($_POST["q"]<=$q){
}else{
	$error = array("producto_id"=>$_POST["producto_id"],"message"=>"No hay suficiente stock el producto.");
	$errors[count($errors)] = $error;
	$can=false;
}

if($can==false){
$_SESSION["errors"] = $errors;
	?>	
<script>
	// Core::redir("index.php?view=vender&id_sucursal=".$_POST["id_sucursal"]);
	window.location="index.php?view=transacciones&id_sucursal=".$_POST["id_sucursal"];
</script>
<?php
}
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
	$_SESSION["cart"] = $cart;
}

if($found==false){
    $nc = count($cart);
	$product = array("producto_id"=>$_POST["producto_id"],"q"=>$_POST["q"]);
	$cart[$nc] = $product;
//	print_r($cart);
	$_SESSION["cart"] = $cart;
}

}
}
Core::redir("index.php?view=transacciones&id_sucursal=".$_POST["id_sucursal"]);
 // print "<script>window.location='index.php?view=vender&id_sucursal='.$_POST["id_sucursal"];</script>";
// unset($_SESSION["cart"]);

?>