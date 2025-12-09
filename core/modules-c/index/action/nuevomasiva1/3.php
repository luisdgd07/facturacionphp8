<?php

for ($i = 1; $i <= $_POST['cantidadd'] ; $i++) {
    $masiva = new VentaData1();
    foreach ($_POST as $k => $v) {
      $masiva->$k = $v;
      # code...
    }
    $masiva->iva10=$_POST["iva10"];
    
    $a1=$_POST['total'];
    $a2=$_POST['cantidadd'];
    $a3=$_POST['precio'];
    $facto=round(2000/$a3);
    $facto1=(2000/$a3);
    if ($a3<2000) {
    $masiva->montofactura=$facto*$a3;
    }
    if ($a3==2000) {
      $masiva->montofactura=$facto1*$a3;
    }
    $a4=$_POST['cantidadd'];
    $a5=$_POST['cantidadd']/$a4;
    $masiva->cantidad=$a5;
    $b1=$_POST['numinicio'];
    $b2=$_POST['numfin'];
    $b3=$_POST['serie'];
    $b4=$_POST['diferencia'];
    $b9=($b2-$b4)+$i;
    // for ($j = 0; $j = round(($_POST['cantidadd']/(2000/$_POST['precio']))) ; $j++) {
    //   $b9=($b2-$b4)+$j; 
    // }
    $masiva->factura=$b3."-"."0000".($b9);
      // for ($number = 1; $number<= round(($_POST['cantidadd']/(2000/$_POST['precio']))); $number++) {
      //    echo $number;

      // }



    $_SESSION["registro"]= 1;
    $difi=$i;
    $s=$masiva->registro1();
    // Core::alert("Registro de manera Éxistosa...!");
    
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

    Core::redir("index.php?view=masiva&id_sucursal=".$_POST["id_sucursal"]);
?>










































<?php

for ($i = 1; $i <= $_POST['cantidadd'] ; $i++) {
    $masiva = new VentaData();
    foreach ($_POST as $k => $v) {
      $masiva->$k = $v;
      # code...
    }
    $masiva->iva10=$_POST["iva10"];
    
    $a1=$_POST['total'];
    $a2=$_POST['cantidadd'];
    $a3=$_POST['precio'];
    $facto=round(2000/$a3);
    $facto1=(2000/$a3);
    if ($a3<2000) {
    $masiva->montofactura=$facto*$a3;
    }
    if ($a3==2000) {
      $masiva->montofactura=$facto1*$a3;
    }
    $a4=$_POST['cantidadd'];
    $a5=$_POST['cantidadd']/$a4;
    $masiva->cantidad=$a5;
    $b1=$_POST['numinicio'];
    $b2=$_POST['numfin'];
    $b3=$_POST['serie'];
    $b4=$_POST['diferencia'];
    $b9=($b2-$b4)+$i;
    // for ($j = 0; $j = round(($_POST['cantidadd']/(2000/$_POST['precio']))) ; $j++) {
    //   $b9=($b2-$b4)+$j; 
    // }
    $masiva->factura=$b3."-"."0000".($b9);
      // for ($number = 1; $number<= round(($_POST['cantidadd']/(2000/$_POST['precio']))); $number++) {
      //    echo $number;

      // }


    $masiva->total=$a1/$a4;
    $masiva->ventapadre=$_POST['venta_id'];
    $_SESSION["registro"]= 1;
    $difi=$i;
    $s=$masiva->registro1();
    // Core::alert("Registro de manera Éxistosa...!");
    
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

    Core::redir("index.php?view=masiva&id_sucursal=".$_POST["id_sucursal"]);
?>