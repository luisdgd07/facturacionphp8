<?php
$id_sucursal=$_POST["id_sucursal"];
$stock = $_POST["stock"];
$tipoproducto = $_POST["tipoproducto"];
$producto_id = $_POST["producto_id"];
$precios = $_POST["precios"];
$precio = $_POST["precio"];
$q = $_POST["q"];
$cli = $_POST["cli"];
$stockk=1;
$qq=1;
for ($i=0; $i < count($stock) ; $i++) { 
	if(!isset($_SESSION["cart"])){

		if ($tipoproducto[$i]=="Producto") {
			$product = array("producto_id"=>$producto_id[$i],"precio"=>$precio[$i],"q"=>$q[$i],"stock"=>$stock[$i],"tipoproducto"=>$tipoproducto[$i],"precios"=>$precios[$i],"cli"=>$cli[$i]);
			$_SESSION["cart"] = array($product);
		} 
		if ($tipoproducto[$i]=="Servicio") {
			$product = array("producto_id"=>$producto_id[$i],"precio"=>$precio[$i],"q"=>$qq,"stock"=>$stockk,"tipoproducto"=>$tipoproducto[$i],"precios"=>$precios[$i],"cli"=>$cli[$i]);
			$_SESSION["cart"] = array($product);
		}
		


		$cart = $_SESSION["cart"];

///////////////////////////////////////////////////////////////////
		$num_succ = 0;
		$process=false;
		$errors = array();
		if ($tipoproducto[$i]=="Producto") {
			foreach($cart as $c){
			$q = OperationData::getQYesFf($c["producto_id"]);
			if($c["q"]<=$q){
				$num_succ++;
			}else{
				$error = array("producto_id"=>$c["producto_id"],"message"=>"No hay suficiente cantidad de producto en inventario.");
				$errors[count($errors)] = $error;
			}

		}
		} 
		if ($tipoproducto[$i]=="Servicio") {
			foreach($cart as $c){
			$q = 2;
			if($qq<=$q){
				$num_succ++;
			}else{
				$error = array("producto_id"=>$c["producto_id"],"message"=>"No hay suficiente cantidad de producto en inventario.");
				$errors[count($errors)] = $error;
			}

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
				window.location="index.php?view=vender&id_sucursal=".$producto_id[$i];
			</script>
			<?php
		}




	}else {

		$found = false;
		$cart = $_SESSION["cart"];
		$index=0;

		if ($tipoproducto[$i]=="Producto") {
			$q = OperationData::getQYesFf($producto_id[$i]);
			$can = true;
			if($q[$i]<=$q){
			}else{
				$error = array("producto_id"=>$producto_id,"message"=>"No hay suficiente cantidad de producto en inventario.");
				$errors[count($errors)] = $error;
				$can=false;
			}
		} 
		if ($tipoproducto[$i]=="Servicio") {
			$q = 1;
			$can = true;
			if($q[$i]<=$q){
			}else{
				$error = array("producto_id"=>$producto_id,"message"=>"No hay suficiente cantidad de producto en inventario.");
				$errors[count($errors)] = $error;
				$can=false;
			}
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
		if($c["producto_id"]==$producto_id){
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
		$q2 = $q[$i];
		$cart[$index]["q"]=$q1+$q2;
		$_SESSION["cart"] = $cart;


	}

	if($found==false){
		$nc = count($cart);
		if ($tipoproducto[$i]=="Producto") {
			$product = array("producto_id"=>$producto_id[$i],"precio"=>$precio[$i],"q"=>$q[$i],"stock"=>$stock[$i],"tipoproducto"=>$tipoproducto[$i],"precios"=>$precios[$i],"cli"=>$cli[$i]);
			$cart[$nc] = $product;
		} 
		if ($tipoproducto[$i]=="Servicio") {
			$product = array("producto_id"=>$producto_id[$i],"precio"=>$precio[$i],"q"=>$qq,"stock"=>$stockk,"tipoproducto"=>$tipoproducto[$i],"precios"=>$precios[$i],"cli"=>$cli[$i]);
			$cart[$nc] = $product;
		}
//	print_r($cart);
		$_SESSION["cart"] = $cart;
	}

}
}
// Core::alert("todo un ÉXITO....!");
}
Core::redir("index.php?view=vender&id_sucursal=".$_POST["tid"]);
?>