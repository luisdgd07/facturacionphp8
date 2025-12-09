<?php
if(isset($_SESSION["reabastecer"])){
	$cart = $_SESSION["reabastecer"];
	if(count($cart)>0){

$process = true;

//////////////////////////////////
		if($process==true){
			$sell = new VentaData();
			$sell->usuario_id = $_SESSION["admin_id"];
			 if(isset($_POST["cliente_id"]) && $_POST["cliente_id"]!=""){
			 	$sell->cliente_id=$_POST["cliente_id"];
 				$s = $sell->abastecer_producto_proveedor();
			 }else{
 				$s = $sell->add_abastecer();
			 }


		foreach($cart as  $c){


			$op = new OperationData();
			 $op->producto_id = $c["producto_id"] ;
			 $op->accion_id=1; // 1 - entrada
			 $op->venta_id=$s[1];
			 $op->q= $c["q"];

			if(isset($_POST["is_oficiall"])){
				$op->is_oficiall = 1;
			}

			$add = $op->registro_producto();			 		

		}
			unset($_SESSION["reabastecer"]);
			setcookie("selled","selled");
////////////////////
Core::alert("Se agragaron con exito");
print "<script>window.location='index.php?view=ajustarstock';</script>";
		}
	}
}



?>
