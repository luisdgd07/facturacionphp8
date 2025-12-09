<?php
// include "fpdf/fpdf.php";
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

$pdf = new FPDF($orientation='P',$unit='mm', array(45,100000));
$ventas = VentaData::getById($_GET["id_venta"]);
$procesos = VentaData::verventapadre($ventas->id_venta);
$cantidadfacto=0;
$totall=0;
$totall10px=0;
$totall5px=0;
$totall0px=0;
$totaliva5=0;
$totaliva10=0;
$pdf->AddPage();
$pdf->SetFont('Arial','',1); 
$textypos+=0;
$pdf->setX(2);
// $pdf->Cell(5,$textypos,count(VentaData::verventapadre($ventas->id_venta)));$cantidadfacto=count(VentaData::verventapadre($ventas->id_venta));
foreach ($procesos as $proceso) {
$pdf->SetFont('Arial','',5); 
$textypos += 20;
$pdf->setY(2);
$pdf->setX(6);
$pdf->Cell(5,$textypos,"");

$pdf->SetFont('','',3);
$textypos+=6;
$pdf->setX(0);
$pdf->Cell(0,$textypos,"---------------------------------------------------------------------------------------------------------------------------");
$pdf->SetFont('Arial','B',7); 
$textypos+=3;
$pdf->setX(11);
$pdf->Cell(0,$textypos,$ventas->verSocursal()->nombre);

$pdf->SetFont('Arial','',3);
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,$ventas->verSocursal()->descripcion);
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"UBICADO EN: ".$ventas->verSocursal()->direccion);
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"SUCURSAL: ".$ventas->verSocursal()->id_sucursal);
$pdf->SetFont('Arial','',4);
$textypos+=6;
$pdf->setX(10);
$pdf->Cell(0,$textypos,"Con RUC : ".$ventas->verSocursal()->ruc);
$textypos+=4;
$pdf->setX(10);
$pdf->Cell(0,$textypos,"TELEFONO : ".$ventas->verSocursal()->telefono);
$textypos+=4;
$pdf->setX(10);


$phpdateini = strtotime( $ventas->VerConfiFactura()->inicio_timbrado );
$mysqldateini = date( 'd-m-Y', $phpdateini);
$pdf->Cell(0,$textypos,"VALIDO DESDE : ".$mysqldateini);
$textypos+=4;
$pdf->setX(10);
$phpdatefin = strtotime( $ventas->VerConfiFactura()->fin_timbrado );
$mysqldatefin = date( 'd-m-Y', $phpdatefin);
$pdf->Cell(0,$textypos,"VALIDO HASTA : ".$mysqldatefin);


$textypos+=4;
$pdf->setX(10);
// $pdf->Cell(0,$textypos,"FACTURA : ".$proceso->factura);
if ($proceso->numerocorraltivo>=1&$proceso->numerocorraltivo<10) {
    $pdf->Cell(0,$textypos,$proceso->VerConfiFactura()->comprobante1." ".$proceso->metodopago." : ".$proceso->VerConfiFactura()->serie1." - "."000000".$proceso->numerocorraltivo);
}else{
    if ($proceso->numerocorraltivo>=10&$proceso->numerocorraltivo<100) {
    $pdf->Cell(0,$textypos,$proceso->VerConfiFactura()->comprobante1." ".$proceso->metodopago." : ".$proceso->VerConfiFactura()->serie1." - "."00000".$proceso->numerocorraltivo);
}
else{
    if ($proceso->numerocorraltivo>=100&$proceso->numerocorraltivo<1000) {
    $pdf->Cell(0,$textypos,$proceso->VerConfiFactura()->comprobante1." ".$proceso->metodopago." : ".$proceso->VerConfiFactura()->serie1." - "."0000".$proceso->numerocorraltivo);
}
else{
    if ($proceso->numerocorraltivo>=1000&$proceso->numerocorraltivo<10000) {
    $pdf->Cell(0,$textypos,$proceso->VerConfiFactura()->comprobante1." ".$proceso->metodopago." : ".$proceso->VerConfiFactura()->serie1." - "."000".$proceso->numerocorraltivo);
}
else{
    if ($proceso->numerocorraltivo>=10000&$proceso->numerocorraltivo<100000) {
    $pdf->Cell(0,$textypos,$proceso->VerConfiFactura()->comprobante1." ".$proceso->metodopago." : ".$proceso->VerConfiFactura()->serie1." - "."00".$proceso->numerocorraltivo);
}
else{
    if ($proceso->numerocorraltivo>=100000&$proceso->numerocorraltivo<1000000) {
    $pdf->Cell(0,$textypos,$proceso->VerConfiFactura()->comprobante1." ".$proceso->metodopago." : ".$proceso->VerConfiFactura()->serie1." - "."0".$proceso->numerocorraltivo);
}
else{
    
    $pdf->Cell(0,$textypos,"SIN VALOR");
}
}
}
}
}
}
$textypos+=4;
$pdf->setX(18);
$pdf->Cell(0,$textypos,"IVA Incluido ");
$pdf->SetFont('Arial','',3);
$textypos+=3;
$pdf->setX(0);
$pdf->Cell(0,$textypos,"---------------------------------------------------------------------------------------------------------------------------");
$textypos+=3;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"CLIENTE : ".$ventas->getCliente()->nombre." ".$ventas->getCliente()->apellido);
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"R.U.C. : ".$ventas->getCliente()->ruc);
$textypos+=2;
$pdf->setX(0);
$pdf->Cell(0,$textypos,"---------------------------------------------------------------------------------------------------------------------------");
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"FECHA Y HORA : ".$ventas->fecha);
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"CAJA : ");
$pdf->setX(25);
$pdf->Cell(0,$textypos,$ventas->VerTipoModena()->nombre);
// if ($ventas->cambio=="1") {
//     $pdf->Cell(0,$textypos,"GUARANIES");
    
// }
// else
//         if ($ventas->cambio=="6800") {
//             $pdf->Cell(0,$textypos,"DOLAR");
//         }
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"CAJERO : ".$ventas->getUser()->nombre." ".$ventas->getUser()->apellido);
$textypos+=3;
$pdf->setX(0);
$pdf->Cell(0,$textypos,"---------------------------------------------------------------------------------------------------------------------------");
$textypos+=2;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"PRODUCTO");
$pdf->setX(19);
$pdf->Cell(0,$textypos,"CANTIDAD");
$pdf->setX(27);
$pdf->Cell(0,$textypos,"PRECIO");
$pdf->setX(36);
$pdf->Cell(0,$textypos,"TOTAL");
$textypos+=2;
$pdf->setX(0);
$pdf->Cell(0,$textypos,"---------------------------------------------------------------------------------------------------------------------------");
// --------------------------------
$textypos+=3;
$pdf->setX(2);
$pdf->Cell(0,$textypos,$proceso->getProducto()->nombre);
$pdf->setX(20);
$pdf->Cell(0,$textypos,round($proceso->cantidad));
$pdf->setX(26);
$pdf->Cell(0,$textypos,$proceso->getProducto()->precio_venta);
$pdf->setX(35);
if ($proceso->getProducto()->impuesto=="10") {
        $pdf->Cell(0,$textypos,$proceso->total);$totall10px=round(($proceso->total)/11);
    }else{
        if ($proceso->getProducto()->impuesto=="5") {
         $pdf->Cell(0,$textypos,$proceso->total);$totall5px=round(($proceso->total)/21);
    }else{
        if ($proceso->getProducto()->impuesto=="0") {
        $pdf->Cell(0,$textypos,$proceso->total);$totall0px=$proceso->total;
    }else{
        if ($proceso->getProducto()->impuesto=="10") {
        $pdf->Cell(0,($proceso->total)/1.1);$totaliva10=round(($proceso->total)/1.1);
    }
    else
    if ($proceso->getProducto()->impuesto=="5") {
         $pdf->Cell(0,($proceso->total)/1.05);$totaliva5=round(($proceso->total)/1.05);
    }
    }
    }
    }
    
    
    
$textypos+=2;
$pdf->setX(0);
$pdf->Cell(0,$textypos,"---------------------------------------------------------------------------------------------------------------------------");
$pdf->SetFont('Arial','B',4); 
$textypos+=4;
$pdf->setX(10);
$pdf->Cell(0,$textypos,"TOTAL A PAGAR: ");
$pdf->SetFont('Arial','',4); 
$pdf->setX(23);
$pdf->Cell(0,$textypos,number_format($proceso->total, 2, '.', ','));  
$pdf->SetFont('Arial','B',4); 
$textypos+=4;
$pdf->setX(10);
$pdf->Cell(0,$textypos,"EFECTIVO: ");
$pdf->SetFont('Arial','',4); 
$pdf->setX(23);
$pdf->Cell(0,$textypos,number_format($proceso->total, 2, '.', ','));
// $pdf->Cell(0,$textypos,$proceso->montofactura/$proceso->cantidad);
$pdf->SetFont('Arial','',3); 
$textypos+=3;
$pdf->setX(0);
$pdf->Cell(0,$textypos,"---------------------------------------------------------------------------------------------------------------------------");
$pdf->SetFont('Arial','',3); 
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"TOTAL EXENTO : ");
$pdf->setX(18);
$pdf->Cell(0,$textypos,number_format($proceso->exenta, 2, '.', ','));  
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"TOTAL GRAVADA 5% : ");
$pdf->setX(18);
$pdf->Cell(0,$textypos,number_format($proceso->total5, 2, '.', ','));
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"TOTAL GRAVADA 10% : ");
$pdf->setX(18);
$pdf->Cell(0,$textypos,number_format($proceso->total10, 2, '.', ','));
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"TOTAL I.V.A. 5%: ");
$pdf->setX(18);
$pdf->Cell(0,$textypos,number_format($proceso->iva5, 2, '.', ','));
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"TOTAL I.V.A. 10%: ");
$pdf->setX(18);
$pdf->Cell(0,$textypos,number_format($proceso->iva10, 2, '.', ','));
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"TOTAL I.V.A. : ");
$pdf->setX(18);
$pdf->Cell(0,$textypos,number_format($proceso->iva5+$proceso->iva10, 2, '.', ','));
$textypos+=3;
$pdf->setX(0);
$pdf->Cell(0,$textypos,"---------------------------------------------------------------------------------------------------------------------------");
$textypos+=4;
$pdf->setX(13);
$pdf->Cell(0,$textypos,"* GRACIAS POR SU COMPRA *");

$pdf->SetFont('Arial','B',5); 
$textypos+=5;
$pdf->setX(0);
$pdf->Cell(0,$textypos,"---------------------------------------------------------------------------------------------------------------------------");
$pdf->SetFont('Arial','B',5); 
$textypos+=1;
$pdf->setX(0);
$pdf->Cell(0,$textypos,"---------------------------------------------------------------------------------------------------------------------------");
    }

$pdf->output();
