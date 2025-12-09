<?php

    $cart = $_SESSION["reabastecer"];

    $nuevo_array4 = array();

    $q = OperationData::getQYesFf($_POST["producto_id"]);
  //  if($_POST["cantidad"] >=$q){
       foreach($cart as $c){
            if($c['producto_id'] == $_POST["producto_id"]){
                array_push($nuevo_array4, array("producto_id"=>$_POST["producto_id"],"q"=>$_POST["cantidad"],"precio"=>$_POST["precio_nuevo"]));
            }else{
                array_push($nuevo_array4, array("producto_id"=>$c["producto_id"],"q"=>$c["q"],"precio"=>$c["precio"]));
            }
        }
        $_SESSION["reabastecer"] = $nuevo_array4;
        //print "<script>alert('Se actualizo a la cantidad ingresada.');window.location.reload();</script>";
  //  }else{
        //print "<script>alert('La cantidad ingresada supera el stock disponible.');</script>";
  //  }

?>