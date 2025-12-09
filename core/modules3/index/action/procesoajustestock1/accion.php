<?php


$c= VentaData::getnumercionfact($_POST["comprobante2"], $_POST["id_sucursal"]);

 if($c==null){

if(isset($_SESSION["reabastecer"])){
	$cart = $_SESSION["reabastecer"];
	if(count($cart)>0){
		// $id=$_POST["id"];

			$sell = new VentaData();
			$sell->usuario_id = $_SESSION["admin_id"];
			$sell->formapago2 = $_POST["formapago2"];
			$sell->comprobante2 = $_POST["comprobante2"];
			$sell->timbrado2 = $_POST["timbrado2"];
			$sell->codigo2 = $_POST["codigo2"];
			$sell->fecha2 = $_POST["fecha2"];
			$sell->condicioncompra2 = $_POST["condicioncompra2"];
			
			$sell->cambio = $_POST["cambio"];
			$sell->cambio2 = $_POST["cambio2"];
			$sell->simbolo2 = $_POST["simbolo2"];
			
			$grabada102 = str_replace(',', '', $_POST["grabada102"]);
			$sell->grabada102 =  $grabada102;
			$iva102 = str_replace(',', '', $_POST["iva102"]);
			$sell->iva102 = $iva102 ;
			
			$grabada52 = str_replace(',', '', $_POST["grabada52"]);
			$sell->grabada52 = $grabada52;
			
			$iva52 = str_replace(',', '', $_POST["iva52"]);
			$sell->iva52 = $iva52;
			$excenta2 = str_replace(',', '', $_POST["excenta2"]);
			$sell->excenta2 = $excenta2;
			$total = str_replace(',', '', $_POST["money"]); 
			$sell->total = $total; 
			// $a2=$_POST['tipomoneda_id'];
			$a1=$_POST['id_sucursal'];
			$sell->tipomoneda_id=$_POST["idtipomoneda"];
			$sell->sucursal_id=$a1;
			$sell->fecha=$_POST["fecha"];
		
			 	$sell->cliente_id=$_POST["cliente_id"];
 				$s = $sell->abastecer_producto_proveedor1();


		foreach($cart as  $c){


			$op = new OperationData();
			 $op->producto_id = $c["producto_id"] ;
			 
			  $stc = $_POST["stock_trans"];
			 $op->stock_trans=$stc;
			
			  $op->motivo="COMPRA"." ".$s[1];
			 
			 $op->accion_id=1; // 1 - entrada
			 $op->venta_id=$s[1];
			 $op->q= $c["q"];
			 $op->precio= $c["precio"];
			 $op->precio1= $c["precio"];
			 $b1=$_POST['id_sucursal'];
			 $op->sucursal_id=$b1;

			if(isset($_POST["is_oficiall"])){
				$op->is_oficiall = 1;
			}
			
	

			$add = $op->registro_producto1();
           // $add2 = $op->actualizar2();


           $actualizar = new StockData();
           $suma=$c["stock"]+$c["q"];
		   $actualizar->CANTIDAD_STOCK=	$suma;
		   $actualizar->PRODUCTO_ID=$c["producto_id"];
		   $actualizar->actualizar();
		}
			unset($_SESSION["reabastecer"]);
			setcookie("selled","selled");
////////////////////
Core::alert("REGISTRO DE COMPRA REALIZADO CON EXITO");
Core::redir("index.php?view=compras1&id_sucursal=".$_POST["id_sucursal"]);
// print "<script>window.location='index.php?view=ajustarstock';</script>";
		
	}
	
	else{
Core::alert("HUBO UN ERROR EN LA CARGA ...!");
Core::redir("index.php?view=ajustarstock&id_sucursal=".$_POST["id_sucursal"]);
}

	
	
}
}else{
Core::alert("NUMERO DE FACTURA YA REGISTRADO, NO PUEDE REPETIRLO...!");
Core::redir("index.php?view=ajustarstock&id_sucursal=".$_POST["id_sucursal"]);
}


?>
