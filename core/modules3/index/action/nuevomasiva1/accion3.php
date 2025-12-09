<?php
  $impuestos=$_POST["impuesto"];
  $cantidadmasiva=round($_POST["cantidaconfigmasiva"]);
  
  $precio_producto = round((($_POST["total"]/$_POST["cantidadd"])),6);
  
  
  //$precio_producto=$_POST["precio"];
  $cant_productos_x_factura_fin=floor($cantidadmasiva/$precio_producto);
  $total_venta=$_POST["total"];
  $cantidad_venta=$_POST["cantidadd"];
  $cantidad_facturas=floor($cantidad_venta/$cant_productos_x_factura_fin);
  $monto_total_facturas = ($precio_producto*$cant_productos_x_factura_fin)*$cantidad_facturas;
 



 $monto_resto = $total_venta - $monto_total_facturas;
  //   echo json_encode(array(
  // "cantidadmasiva" => $cantidadmasiva,
  // "precio_producto"=>$precio_producto,
  //  "cant_productos_x_factura"=>$cant_productos_x_factura,
  //  "total_venta"=>$total_venta,
  //  "cantidad_facturas"=>$cantidad_facturas,
  //  "redondeo" => floor(15.8856)
  // ));
  
  
  
  // NUEVO
  $cantidad_porfact=0;
  
  $cant_productos_x_factura =1
  

 
	    if (($monto_total_venta <= $total_venta )) {
			
    for ($i = 1; $cantidad_porfact <= $cantidad_venta ; $i++) 
    {
      $masiva = new VentaData();
      foreach ($_POST as $k => $v) {
        $masiva->$k = $v; 
      }
      $totalmasiva=round(($cant_productos_x_factura*$precio_producto),6);
      $gravadass10=$totalmasiva/1.1;
      $ivass10=$totalmasiva/11;
      $gravadass5=$totalmasiva/1.05;
      $ivass5=$totalmasiva/21;
      $gravadass0=$totalmasiva;
      if ($impuestos==10) {
        $masiva->total10=$gravadass10;
        $masiva->total5=0;
        $masiva->iva10=$ivass10;
        $masiva->iva5=0;
        $masiva->exenta= 0;
      }else{
        if ($impuestos==5) {
          $masiva->total10=0;
          $masiva->total5=$gravadass5;
          $masiva->iva10=0;
          $masiva->iva5=$ivass5;
          $masiva->exenta= 0;
        }else{
          if ($impuestos==0) {
            $masiva->total10=0;
            $masiva->total5=0;
            $masiva->iva10=0;
            $masiva->iva5=0;
            $masiva->exenta= $gravadass0;
          }
        }
      }
      // $masiva->iva10=$_POST["iva10"];
      $masiva->cantidad=$cant_productos_x_factura;
      $b1=$_POST['numinicio'];
      $b2=$_POST['numfin'];
      $b3=$_POST['serie'];
      $b4=$_POST['diferencia'];
      // $b9=($b2-$b4)+$i;
      $b9=(($b2-$b4)-1)+$i;
	  
	  
	   if ($b9>=1&$b9<10){
             $masiva->factura=$b3."-"."000000".$b9;
                     }else{
        if ($b9>=10&$b9<100) {
         $masiva->factura=$b3."-"."00000".$b9;
		             }else{
        if ($b9>=100&$b9<1000){
		$masiva->factura=$b3."-"."0000".$b9;
		             }else{
         if ($b9>=1000&$b9<10000){ 
        $masiva->factura=$b3."-"."000".$b9;
		              }else{
        if ($b9>=100000&$b9<1000000){
		$masiva->factura=$b3."-"."00".$b9;
		              }else{
         if ($b9>=1000000&$b9<10000000){ 
                    $masiva->factura=$b3."-"."0".$b9;
                       }else{
                        
                     }
                     }
                     } 
                     }
                     } 
                     }
	  
	  
	  
      //$masiva->factura=$b3."-"."0000".($b9);
      $masiva->numerocorraltivo=$b9;
      $masiva->total=round(($cant_productos_x_factura*$precio_producto),6);
      $masiva->ventapadre=$_POST['venta_id'];
      $_SESSION["registro"]= 1;
      $difi=$i;
      $tipo=1;
      $masivasssssssss=$cantidad_facturas;
      $masiva->tipo_venta=$tipo;
      $masiva->fecha=$_POST["fecha"];
      $s=$masiva->registro1();  
	  
	  
	  $cant_productos_x_factura=rand(1,$cant_productos_x_factura_fin);
	  
	  $cantidad_porfact +=$cant_productos_x_factura;
	  
	  $monto_total1 +=$totalmasiva;
    }
  }else{
    
	
	
	
   $total_cantidad_facturas = $cantidad_porfact;
    $cantidad_restante_productos = $cantidad_venta - $total_cantidad_facturas;

    $total_monto_restante = $precio_producto * $cantidad_restante_productos;
	
	$monto_total_venta =$monto_total1;

   
		   
	
	
	




    for ($i = 1; $cantidad_porfact <= $cantidad_venta ; $i++) 
    {
      $masiva1 = new VentaData();
      foreach ($_POST as $k => $v) {
        $masiva1->$k = $v; 
      }
      $totalmasiva=$cant_productos_x_factura*$precio_producto;
      $gravadass10=$totalmasiva/1.1;
      $ivass10=$totalmasiva/11;
      $gravadass5=$totalmasiva/1.05;
      $ivass5=$totalmasiva/21;
      $gravadass0=$totalmasiva;
      // $masiva1->total10=$gravadass10;
      // $masiva1->total5=$gravadass5;
      // $masiva1->iva10=$ivass10;
      // $masiva1->iva5=$ivass5;
      // $masiva1->exenta= $gravadass0;
      if ($impuestos==10) {
        $masiva1->total10=$gravadass10;
        $masiva1->total5=0;
        $masiva1->iva10=$ivass10;
        $masiva1->iva5=0;
        $masiva1->exenta= 0;
      }else{
        if ($impuestos==5) {
          $masiva1->total10=0;
          $masiva1->total5=$gravadass5;
          $masiva1->iva10=0;
          $masiva1->iva5=$ivass5;
          $masiva1->exenta= 0;
        }else{
          if ($impuestos==0) {
            $masiva1->total10=0;
            $masiva1->total5=0;
            $masiva1->iva10=0;
            $masiva1->iva5=0;
            $masiva1->exenta= $gravadass0;
          }
        }
      }
      // $masiva1->iva10=$_POST["iva10"];
      $masiva1->cantidad=$cant_productos_x_factura;
      $b1=$_POST['numinicio'];
      $b2=$_POST['numfin'];
      $b3=$_POST['serie'];
      $b4=$_POST['diferencia'];
      $b9=(($b2-$b4)-1)+$i;
	  
	  
	   if ($b9>=1&$b9<10){
             $masiva1->factura=$b3."-"."000000".$b9;
                     }else{
        if ($b9>=10&$b9<100) {
         $masiva1->factura=$b3."-"."00000".$b9;
		             }else{
        if ($b9>=100&$b9<1000){
		$masiva1->factura=$b3."-"."0000".$b9;
		             }else{
         if ($b9>=1000&$b9<10000){ 
        $masiva1->factura=$b3."-"."000".$b9;
		              }else{
        if ($b9>=100000&$b9<1000000){
		$masiva1->factura=$b3."-"."00".$b9;
		              }else{
         if ($b9>=1000000&$b9<10000000){ 
                    $masiva1->factura=$b3."-"."0".$b9;
                       }else{
                        
                     }
                     }
                     } 
                     }
                     } 
                     }
	  
	  
	  
	  
	  
      //$masiva1->factura=$b3."-"."0000".($b9);
      $masiva1->numerocorraltivo=$b9;
      $masiva1->total=round(($cant_productos_x_factura*$precio_producto),6);
      $masiva1->ventapadre=$_POST['venta_id'];
      $_SESSION["registro"]= 1;
      $difi=$i;
      $tipo=1;
      $masiva1->tipo_venta=$tipo;
      $masiva1->fecha=$_POST["fecha"];
      $s=$masiva1->registro1();  
    }

    //registro del resto
    $masiva2 = new VentaData();
      foreach ($_POST as $k => $v) {
        $masiva2->$k = $v; 
      }
      $gravadas10=$total_monto_restante/1.1;
      $ivas10=$total_monto_restante/11;
      $gravadas5=$total_monto_restante/1.05;
      $ivas5=$total_monto_restante/21;
      $gravadas0=$total_monto_restante;
      if ($impuestos==10) {
        $masiva2->total10=$gravadas10;
        $masiva2->total5=0;
        $masiva2->iva10=$ivas10;
        $masiva2->iva5=0;
        $masiva2->exenta= 0;
      }else{
        if ($impuestos==5) {
          $masiva2->total10=0;
          $masiva2->total5=$gravadas5;
          $masiva2->iva10=0;
          $masiva2->iva5=$ivas5;
          $masiva2->exenta= 0;
        }else{
          if ($impuestos==0) {
            $masiva2->total10=0;
            $masiva2->total5=0;
            $masiva2->iva10=0;
            $masiva2->iva5=0;
            $masiva2->exenta= $gravadas0;
          }
        }
      }
      $masiva2->cantidad=$cantidad_restante_productos;
      $b1=$_POST['numinicio'];
      $b2=$_POST['numfin'];
      $b3=$_POST['serie'];
      $b4=$_POST['diferencia'];
      $b9=(($b2-$b4)-1)+$i;
	 
	    if ($b9>=1&$b9<10){
             $masiva2->factura=$b3."-"."000000".$b9;
                     }else{
        if ($b9>=10&$b9<100) {
         $masiva2->factura=$b3."-"."00000".$b9;
		             }else{
        if ($b9>=100&$b9<1000){
		$masiva2->factura=$b3."-"."0000".$b9;
		             }else{
         if ($b9>=1000&$b9<10000){ 
        $masiva2->factura=$b3."-"."000".$b9;
		              }else{
        if ($b9>=100000&$b9<1000000){
		$masiva2->factura=$b3."-"."00".$b9;
		              }else{
         if ($b9>=1000000&$b9<10000000){ 
                    $masiva2->factura=$b3."-"."0".$b9;
                       }else{
                        
                     }
                     }
                     } 
                     }
                     } 
                     }
	  
	  
	  
     // $masiva2->factura=$b3."-"."0000".($b9);
      $masiva2->numerocorraltivo=$b9;
      $masiva2->total=$total_monto_restante;
      $masiva2->ventapadre=$_POST['venta_id'];
      $_SESSION["registro"]= 1;
      $difi=$i;
      $tipo=1;
      $masiva2->tipo_venta=$tipo;
      $masiva2->fecha=$_POST["fecha"];
      $s=$masiva2->registro1();  
  }
   if(count($_POST)>0){
      $configuracionfactura = ConfigFacturaData::VerId($_POST["id_configfactura"]);
      $jl1 = $_POST["diferencia"];
      $jl2 = $s[1];
      $configuracionfactura->diferencia=($jl1-$difi);
      $configuracionfactura->actualizardiferencia();
    }
    if(count($_POST)>0){
      $masivas = OperationData::getById($_POST["id_proceso"]);
      $masivas->masiva=$_POST["masiva"];
      $masivas->actualizarmasiva();
    }
    if (count($_POST)>0) {
      $actualizartipo_venta = VentaData::getById($_POST["id_venta"]);
      $actualizartipo_venta->tipo_venta=$_POST["tipo_venta"];
      $actualizartipo_venta->actualizartipoventa();
    }
Core::redir("index.php?view=masiva&id_sucursal=".$_POST["id_sucursal"]);
?>