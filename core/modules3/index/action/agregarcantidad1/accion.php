<?php
$tipo=$_POST["tipoproducto"];
if ($tipo=="Producto") {
	if(!isset($_SESSION["cart"])){


		$product = array("producto_id"=>$_POST["producto_id"],"precio"=>$_POST["precio"],"q"=>$_POST["q"],"stock"=>$_POST["stock"],"tipoproducto"=>$_POST["tipoproducto"],"precios"=>$_POST["precios"],"cli"=>$_POST["cli"]);
		$_SESSION["cart"] = array($product);


		$cart = $_SESSION["cart"];

///////////////////////////////////////////////////////////////////
		$num_succ = 0;
		$process=false;
		$errors = array();
		foreach($cart as $c){

			///
			$q = OperationData::getQYesFf($c["producto_id"]);
//			echo ">>".$q;
			if($c["q"]<=$q){
				$num_succ++;


			}else{
				$error = array("producto_id"=>$c["producto_id"],"message"=>"No hay suficiente cantidad de producto en inventario.");
				$errors[count($errors)] = $error;
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
				window.location="index.php?view=vender&id_sucursal=".$_POST["id_sucursal"];
			</script>
			<?php
		}




	}else {

		$found = false;
		$cart = $_SESSION["cart"];
		$index=0;

		$q = OperationData::getQYesFf($_POST["producto_id"]);





		$can = true;
		if($_POST["q"]<=$q){
		}else{
			$error = array("producto_id"=>$_POST["producto_id"],"message"=>"No hay suficiente cantidad de producto en inventario.");
			$errors[count($errors)] = $error;
			$can=false;
		}

		if($can==false){
			$_SESSION["errors"] = $errors;
			?>	
			<script>
	// Core::redir("index.php?view=vender&id_sucursal=".$_POST["id_sucursal"]);
	window.location="index.php?view=vender&id_sucursal=".$_POST["id_sucursal"];
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
		$product = array("producto_id"=>$_POST["producto_id"],"precio"=>$_POST["precio"],"q"=>$_POST["q"],"stock"=>$_POST["stock"],"tipoproducto"=>$_POST["tipoproducto"],"precios"=>$_POST["precios"],"cli"=>$_POST["cli"]);
		$cart[$nc] = $product;
//	print_r($cart);
		$_SESSION["cart"] = $cart;
	}

}
}
Core::redir("index.php?view=vender&id_sucursal=".$_POST["id_sucursal"]);


}
if ($tipo=="Servicio") {
	// print("es Servicio");
	$qq=1;
	$stock=1;
	if (!isset($_SESSION["cart"])) {
		$product = array("producto_id"=>$_POST["producto_id"],"precio"=>$_POST["precio"],"q"=>$_POST["q"],"stock"=>$stock,"tipoproducto"=>$_POST["tipoproducto"],"precios"=>$_POST["precios"],"cli"=>$_POST["cli"]);
		$_SESSION["cart"] = array($product);
		$cart = $_SESSION["cart"];
	// ------------------------------
		$num_succ = 0;
		$process=false;
		$errors = array();
		foreach($cart as $c){
			$q = 2;
			if($qq<=$q){
				$num_succ++;
			}else{
				$error = array("producto_id"=>$c["producto_id"],"message"=>"No hay suficiente cantidad de producto en inventario.");
				$errors[count($errors)] = $error;
			}
		}
		// ---------------
		if($num_succ==count($cart)){
			$process = true;
		}
		if($process==false){
			unset($_SESSION["cart"]);
			$_SESSION["errors"] = $errors;
			?>	
			<script>
				window.location="index.php?view=vender&id_sucursal=".$_POST["id_sucursal"];
			</script>
			<?php 
		// -----
		} 
	} else {

		$found = false;
		$cart = $_SESSION["cart"];
		$index=0;
		$q = 1;

		$can = true;
		if($_POST["q"]<=$q){
		}else{
			$error = array("producto_id"=>$_POST["producto_id"],"message"=>"No hay suficiente cantidad de producto en inventario.");
			$errors[count($errors)] = $error;
			$can=false;
		}

		if($can==false){
			$_SESSION["errors"] = $errors;
			?>	
			<script>
	// Core::redir("index.php?view=vender&id_sucursal=".$_POST["id_sucursal"]);
	window.location="index.php?view=vender&id_sucursal=".$_POST["id_sucursal"];
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
		$product = array("producto_id"=>$_POST["producto_id"],"precio"=>$_POST["precio"],"q"=>$_POST["q"],"stock"=>$stock,"tipoproducto"=>$_POST["tipoproducto"],"precios"=>$_POST["precios"],"cli"=>$_POST["cli"]);
		$cart[$nc] = $product;
//	print_r($cart);
		$_SESSION["cart"] = $cart;
	}

}
}
Core::redir("index.php?view=vender&id_sucursal=".$_POST["id_sucursal"]);
		// ----------

}
?>