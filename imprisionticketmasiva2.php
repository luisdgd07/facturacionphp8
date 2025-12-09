<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" type="text/css" href="ticket.css">
    <script>
    function printPantalla()
{
   document.getElementById('cuerpoPagina').style.marginRight  = "0";
   document.getElementById('cuerpoPagina').style.marginTop = "1";
   document.getElementById('cuerpoPagina').style.marginLeft = "1";
   document.getElementById('cuerpoPagina').style.marginBottom = "0";
   document.getElementById('botonPrint').style.display = "none";
   window.print();
}
</script>
<style>
@media print {
    @page { margin: 0px;
     size: auto; }
}
</style>
</head>

<body id="cuerpoPagina">
    <?php
        include "core/autoload.php";
        include "core/modules/index/model/VentaData.php";
        include "core/modules/index/model/SuccursalData.php";
        include "core/modules/index/model/SucursalUusarioData.php";
        include "core/modules/index/model/UserData.php";
        include "core/modules/index/model/ProveedorData.php";
        include "core/modules/index/model/ClienteData.php";
        include "core/modules/index/model/AccionData.php";
        include "core/modules/index/model/MonedaData.php";
        include "core/modules/index/model/OperationData.php";
        include "core/modules/index/model/ConfigFacturaData.php";
        include "core/modules/index/model/ProductoData.php";
        include "core/modules/index/model/VentaData1.php";
      ?>
            <?php 
            $total=0;
            $ventas = VentaData::getById($_GET["id_venta"]);
            $procesos = VentaData::verventapadre($ventas->id_venta);
             ?>
    
    <div class="zona_impresion">
        <?php foreach ($procesos as $proceso): ?>
        <table border="0" align="center" width="315px" style="font-size:15pt;color:black;">
            
        <thead>
          <tr>
             
               
				<td>******************************************************************************</td>
            </tr>
            
			 <tr>
                <td style="text-align: center; font-size: 20px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $ventas->verSocursal()->nombre?></b></td>
            </tr>
			
			 <tr>
                <td style="text-align: center; font-size: 13px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">De: <?= $ventas->verSocursal()->representante?></td>
            </tr>
			
			
			
			<tr>
             
               
				<td>******************************************************************************</td>
            </tr>
            <tr>
                <td style="text-align: center; font-size: 13px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><?= $ventas->verSocursal()->direccion?></td>
				
            </tr>
           
		   <tr>
               <td style="text-align: center; font-size: 13px;     font-family:  Arial, Helvetica, sans-serif;  " class="text-center"><?= $ventas->verSocursal()->descripcion?></td>
            </tr>
			
            <tr>
               <td style="padding-left: 50px;padding-top: 14px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Ruc: <?= $ventas->verSocursal()->ruc?></td>
            </tr>
            <tr>
                <td style="padding-left: 50px;padding-top: 14px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"> Telef.: <?= $ventas->verSocursal()->telefono?></td>
            </tr>
            <tr>
                <td style="padding-left: 50px;padding-top: 14px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Timbrado: <?= $ventas->VerConfiFactura()->timbrado1?></td>
            </tr>
            <tr>
               <td style="padding-left: 50px;padding-top: 14px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;;" class="text-center">Vigencia desde: <?= date("d/m/Y", strtotime($ventas->VerConfiFactura()->inicio_timbrado))?></td>
            </tr>
            <tr>
                <td style="padding-left: 50px;padding-top: 14px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;;" class="text-center">Vigencia hasta: <?= date("d/m/Y", strtotime($ventas->VerConfiFactura()->fin_timbrado))?></td>
            </tr>
            <tr>
                <td style="padding-left: 45px;padding-top: 14px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><strong>
                    <?php if ($proceso->numerocorraltivo>=1&$proceso->numerocorraltivo<10): ?>
                        <?= $proceso->VerConfiFactura()->comprobante1." ".$proceso->metodopago." Nro: ".$proceso->VerConfiFactura()->serie1."-"."000000".$proceso->numerocorraltivo?>
                    <?php else: ?>
                    <?php if ($proceso->numerocorraltivo>=10&$proceso->numerocorraltivo<100): ?>
                    <?= $proceso->VerConfiFactura()->comprobante1." ".$proceso->metodopago." Nro: ".$proceso->VerConfiFactura()->serie1."-"."00000".$proceso->numerocorraltivo?>
                    <?php else: ?>
                    <?php if ($proceso->numerocorraltivo>=100&$proceso->numerocorraltivo<1000): ?>
                    <?= $proceso->VerConfiFactura()->comprobante1." ".$proceso->metodopago." Nro: ".$proceso->VerConfiFactura()->serie1."-"."0000".$proceso->numerocorraltivo?>
                    <?php else: ?>
                    <?php if ($proceso->numerocorraltivo>=1000&$proceso->numerocorraltivo<10000): ?>
                    <?= $proceso->VerConfiFactura()->comprobante1." ".$proceso->metodopago." Nro: ".$proceso->VerConfiFactura()->serie1."-"."000".$proceso->numerocorraltivo?>
                    <?php else: ?>
                    <?php if ($proceso->numerocorraltivo>=100000&$proceso->numerocorraltivo<1000000): ?>
                    <?= $proceso->VerConfiFactura()->comprobante1." ".$proceso->metodopago." Nro: ".$proceso->VerConfiFactura()->serie1."-"."00".$proceso->numerocorraltivo?>
                    <?php else: ?>
                    <?php if ($proceso->numerocorraltivo>=1000000&$proceso->numerocorraltivo<10000000): ?>
                    <?= $proceso->VerConfiFactura()->comprobante1." ".$proceso->metodopago." Nro: ".$proceso->VerConfiFactura()->serie1."-"."0".$proceso->numerocorraltivo?>
                    <?php else: ?>
                        SIN ACCION
                    <?php endif ?>
                    <?php endif ?>
                    <?php endif ?>
                    <?php endif ?>
                    <?php endif ?>
                    <?php endif ?>
                <strong></td>
            </tr>
           
          
           
			    <tr>
             <td style="padding-left: 50px;padding-top: 15px; font-size: 15px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Cliente: <?php if ($proceso->getCliente()->tipo_doc=="SIN NOMBRE") {echo  $proceso->getCliente()->tipo_doc;
			 
			 }else {echo  $proceso->getCliente()->nombre." ".$proceso->getCliente()->apellido; }?>
		
			 <?php 
               				
			 
			 ?></td>
            </tr>
			
			
            <tr>
                <td style="padding-left: 50px;padding-top: 15px; font-size: 15px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Ruc:<?= $proceso->getCliente()->ruc?></td>
            </tr>
			
			<tr>
                <td style="padding-left: 50px;padding-top: 15px; font-size: 15px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Direc:<?= $proceso->getCliente()->nombre." ".$proceso->getCliente()->apellido?></td>
            </tr>
            <tr>
                <td style="padding-left: 50px;padding-top: 15px; font-size: 15px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Telef.:<?= $proceso->getCliente()->ruc?></td>
            </tr>
            
            <tr>
                <td style="padding-left: 50px;padding-top: 15px; font-size: 15px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Fecha: <?=  date("d/m/Y", strtotime($proceso->fecha))?></td>
            </tr>
            <!--<tr>
                <td style="font-size: 11px;" class="text-center">Moneda: <?= $proceso->VerTipoModena()->nombre?></td>
            </tr> -->
            <tr>
                <td style="padding-left: 50px;padding-top: 15px; font-size: 15px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Atendido por: <?= $proceso->getUser()->nombre." ".$proceso->getUser()->apellido?></td>
            </tr>
          <tr>
             
               
				<td>******************************************************************************</td>
            </tr>
            <!-- <tr>
                <td><strong>PRODUCTO</strong></td>
                <td ><strong><font>CANTIDAD</strong></td>
                <td ><strong>PRECIO</strong></td>
                <td ><strong>TOTAL</strong></td>
            </tr> -->
        </thead>
    </table>
    <table border="0" align="center" width="315px" style="font-size:15pt;color:black;">
        <thead>
             <tr>
                <td style="padding-left: 10px;font-family:  Arial, Helvetica, sans-serif;"><strong><font size="1.5">CANT&nbsp;&nbsp;</font></strong></td>
                <p><td style="width:50%;font-family:  Arial, Helvetica, sans-serif;"><strong><font size="1.5">PRODUCTO&nbsp;&nbsp;</font></strong></td></p>
                <p><td align="right" style="width:10%;font-family:  Arial, Helvetica, sans-serif;"><strong><font size="1.5">PRECIO&nbsp;&nbsp;</font></strong></td></p>
                <p><td align="right" style="width:30%;font-family:  Arial, Helvetica, sans-serif;"><strong><font size="1.5">TOTAL&nbsp;&nbsp;</font></strong></td></p>
            </tr>
            <tr>
               
			     <p><td style="width:10%; font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" align="center"><?= $proceso->cantidad?>&nbsp;&nbsp;</td></p>
                 <p><td style="width:50%; font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"><?= $proceso->getProducto()->nombre?>&nbsp;&nbsp;</td></p>
                 <p><td align="right" style="width:10%; font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?= number_format(($proceso->total)/($proceso->cantidad), 2, ',', '.')?>&nbsp;&nbsp;</td></p>
                 <p><td align="right" style="width:30%; font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"><?= number_format(($proceso->total), 2, ',', '.');$total+=($proceso->total)?>&nbsp;&nbsp;</td></p>
            
			
			</tr>
           
        </thead>
    </table>
    <table border="0" align="center" width="315px" style="font-size:15pt;color:black;">
        <thead>
			 <tr>
                <td style="padding-left: 50px;padding-top: 16px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><strong><font size="3">Total  <?php echo $ventas->VerTipoModena()->simbolo ?>:&nbsp;&nbsp;</font></strong></td>
                <td style="padding-left: 50px;padding-top: 16px; font-size: 17px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><strong><font size="3"><?= number_format($proceso->total, 2, ',', '.')?></font></strong></td>
            </tr>
            <tr>
                <td style="padding-left: 50px;padding-top: 15px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><strong><font size="2">Forma de pago:&nbsp;&nbsp;</font></strong></td>
                <td style="padding-left: 50px;padding-top: 14px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><strong><font size="2">Efectivo</font></strong></td>
            </tr>
			
			<tr>
                <td style="padding-left: 50px;padding-top: 14px; font-size: 15px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><strong><font size="2">Vuelto:&nbsp;&nbsp; </font></strong>0</td>
            </tr>
			
			<tr>
                <td style="padding-left: 50px;padding-top: 16px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center"><strong><font size="2">Tipo Cambio:  <?php if ($ventas->VerTipoModena()->simbolo=="US$") {echo  $ventas->cambio2;
			 
			 }else {echo  1 ;}?>&nbsp;&nbsp;</font></strong></td>
                
            </tr>
			
        </thead>
    </table>
    <table  border="0" align="center" width="315px" style="font-size:15pt;color:black;">
        <thead>
           <tr>
				<td>******************************************************************************</td>
            </tr>
			
			  <td  align="center">DESGLOSE DE IVA:</td>
           
		     <tr>
                <td style="padding-left: 50px;font-size: 16px;font-family:  Arial, Helvetica, sans-serif;">Total Exenta:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?= number_format($proceso->exenta, 2, ',', '.')?></td>
            </tr>
            <tr>
                <td style="padding-left: 50px;font-size: 16px;font-family:  Arial, Helvetica, sans-serif;">Total Gravada 5%:&nbsp;&nbsp;&nbsp;
                <?= number_format($proceso->total5, 2, ',', '.')?></td>
            </tr>
            <tr>
                <td style="padding-left: 50px;font-size: 16px;font-family:  Arial, Helvetica, sans-serif;">Total Gravada 10%:&nbsp;
               <?= number_format($proceso->total10, 2, ',', '.')?></td>
            </tr>
            <tr>
                <td style="padding-left: 50px;font-size: 16px;font-family:  Arial, Helvetica, sans-serif;">Total IVA 5%:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <?= number_format($proceso->iva5, 2, ',', '.')?></td>
            </tr>
            <tr>
                <td style="padding-left: 50px;font-size: 16px;font-family:  Arial, Helvetica, sans-serif;">Total IVA 10%:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <?= number_format($proceso->iva10, 2, ',', '.')?></td>
            </tr>
            <tr>
                <td style="padding-left: 50px;font-size: 16px;font-family:  Arial, Helvetica, sans-serif;">Total IVA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <?= number_format($proceso->iva10+$proceso->iva5, 2, ',', '.')?></td>
            </tr>
		   
             
				<td>******************************************************************************
				</br>
				
				 <tr>
				      <td style="padding-left: 50px;padding-top: 15px; font-size: 16px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">¡Gracias por su compra!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
				
				 </tr>
				
				</br>
				
				 <tr>
               <td style="padding-left: 50px;padding-top: 11px; font-size: 13px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Original: Cliente.
                </td>
				 </tr>
				 <tr>
				<td style="padding-left: 50px;padding-top: 11px; font-size: 13px; font-family:  Arial, Helvetica, sans-serif;" class="text-center">Duplicado: Archivo tributario.
                </td>
				 </tr>

				</td>
				  
            </tr>
          
             
		
        </thead>
    </table>
	 
    </div>
	<?php endforeach ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>


    <div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></a></div>
</body>
</html>