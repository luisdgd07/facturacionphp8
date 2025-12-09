<?php
if(isset($_GET["producto_id"])){
	$cart=$_SESSION["cart"];
	if(count($cart)==1){
	 unset($_SESSION["cart"]);
	}else{
		$ncart = null;
		$nx=0;
		foreach($cart as $c){
			if($c["producto_id"]!=$_GET["producto_id"]){
				$ncart[$nx]= $c;
			}
			$nx++;
		}
		$_SESSION["cart"] = $ncart;
	}

}else{
 unset($_SESSION["cart"]);
}

// print "<script>window.location='index.php?view=vender';</script>";
Core::redir("index.php?view=remision&id_sucursal=".$_GET["id_sucursal"]);
