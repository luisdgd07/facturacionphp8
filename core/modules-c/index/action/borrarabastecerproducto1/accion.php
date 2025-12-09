<?php
if(isset($_GET["producto_id"])){
	$cart=$_SESSION["reabastecer"];
	if(count($cart)==1){
	 unset($_SESSION["reabastecer"]);
	}else{
		$ncart = null;
		$nx=0;
		foreach($cart as $c){
			if($c["producto_id"]!=$_GET["producto_id"]){
				$ncart[$nx]= $c;
			}
			$nx++;
		}
		$_SESSION["reabastecer"] = $ncart;
	}

}else{
 unset($_SESSION["reabastecer"]);
}
Core::redir("index.php?view=ajustarstock&id_sucursal=".$_GET["id_sucursal"]);
// print "<script>window.location='index.php?view=ajustarstock';</script>";

?>