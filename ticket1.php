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

$pdf = new FPDF($orientation='P',$unit='mm', array(45,350));
$ventas = VentaData::getById($_GET["id_venta"]);
$procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
$pdf->AddPage();
$totall=0;
$totall10px=0;
$totall5px=0;
$totall0px=0;
$totaliva5=0;
$totaliva10=0;
$pdf->SetFont('Arial','B',7); 
$textypos = 20;
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
// -------------
$pdf->SetFont('Arial','',4);
$textypos+=6;
$pdf->setX(10);
$pdf->Cell(0,$textypos,"CON RUC. : ".$ventas->verSocursal()->ruc);
$textypos+=4;
$pdf->setX(10);
$pdf->Cell(0,$textypos,"TELEFONO : ".$ventas->verSocursal()->telefono);
$textypos+=4;
$pdf->setX(10);
$pdf->Cell(0,$textypos,"TIMBRADO : ".$ventas->VerConfiFactura()->timbrado1);
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
if ($ventas->numerocorraltivo>=1&$ventas->numerocorraltivo<10) {
    $pdf->Cell(0,$textypos,$ventas->VerConfiFactura()->comprobante1." ".$ventas->metodopago." : ".$ventas->VerConfiFactura()->serie1." - "."000000".$ventas->numerocorraltivo);
}else{
    if ($ventas->numerocorraltivo>=10&$ventas->numerocorraltivo<100) {
    $pdf->Cell(0,$textypos,$ventas->VerConfiFactura()->comprobante1." ".$ventas->metodopago." : ".$ventas->VerConfiFactura()->serie1." - "."00000".$ventas->numerocorraltivo);
}
else{
    if ($ventas->numerocorraltivo>=100&$ventas->numerocorraltivo<1000) {
    $pdf->Cell(0,$textypos,$ventas->VerConfiFactura()->comprobante1." ".$ventas->metodopago." : ".$ventas->VerConfiFactura()->serie1." - "."0000".$ventas->numerocorraltivo);
}
else{
    if ($ventas->numerocorraltivo>=1000&$ventas->numerocorraltivo<10000) {
    $pdf->Cell(0,$textypos,$ventas->VerConfiFactura()->comprobante1." ".$ventas->metodopago." : ".$ventas->VerConfiFactura()->serie1." - "."000".$ventas->numerocorraltivo);
}
else{
    if ($ventas->numerocorraltivo>=10000&$ventas->numerocorraltivo<100000) {
    $pdf->Cell(0,$textypos,$ventas->VerConfiFactura()->comprobante1." ".$ventas->metodopago." : ".$ventas->VerConfiFactura()->serie1." - "."00".$ventas->numerocorraltivo);
}
else{
    if ($ventas->numerocorraltivo>=100000&$ventas->numerocorraltivo<1000000) {
    $pdf->Cell(0,$textypos,$ventas->VerConfiFactura()->comprobante1." ".$ventas->metodopago." : ".$ventas->VerConfiFactura()->serie1." - "."0".$ventas->numerocorraltivo);
}
else{
    
    $pdf->Cell(0,$textypos,"SIN VALOR");
}
}
}
}
}
}



// else{
//     $pdf->Cell(0,$textypos,"Limete Superado");
// }

$textypos+=4;
$pdf->setX(18);
$pdf->Cell(0,$textypos,"IVA Incluido ");
$textypos+=3;
$pdf->setX(0);
$pdf->Cell(0,$textypos,"---------------------------------------------------------------------------------------------------------------------------");
$pdf->SetFont('Arial','',3);
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
foreach ($procesos as $proceso) {
     $producto  = $proceso->getProducto();
    $textypos+=4;
    $pdf->setX(2);
    $pdf->Cell(0,$textypos,$producto->nombre);
    $pdf->setX(22);
    $pdf->Cell(0,$textypos,$proceso->q);
    $pdf->setX(26);
    $pdf->Cell(0,$textypos,$producto->precio_venta);$totall+=((($producto->precio_venta)*$proceso->q)*$ventas->cambio);
    $pdf->setX(35);
    if ($producto->impuesto=="10") {
        $pdf->Cell(0,$textypos,((($producto->precio_venta)*$proceso->q)*$ventas->cambio));$totall10px+=((($producto->precio_venta)*$proceso->q)*$ventas->cambio);
    }else
    if ($producto->impuesto=="5") {
        $pdf->Cell(0,$textypos,((($producto->precio_venta)*$proceso->q)*$ventas->cambio));$totall5px+=((($producto->precio_venta)*$proceso->q)*$ventas->cambio);
    }
    else
    if ($producto->impuesto=="0") {
        $pdf->Cell(0,$textypos,((($producto->precio_venta)*$proceso->q)*$ventas->cambio));$totall0px+=((($producto->precio_venta)*$proceso->q)*$ventas->cambio);
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
$pdf->Cell(0,$textypos,number_format($totall, 2, '.', ','));
$pdf->SetFont('Arial','B',4); 
$textypos+=4;
$pdf->setX(10);
$pdf->Cell(0,$textypos,"EFECTIVO: ");
$pdf->SetFont('Arial','',4); 
$pdf->setX(23);
$pdf->Cell(0,$textypos,number_format($totall, 2, '.', ','));  
$pdf->SetFont('Arial','',3); 
$textypos+=3;
$pdf->setX(0);
$pdf->Cell(0,$textypos,"---------------------------------------------------------------------------------------------------------------------------");
$pdf->SetFont('Arial','',3); 
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"TOTAL EXENTO : ");
$pdf->setX(18);
$pdf->Cell(0,$textypos,number_format($ventas->exenta, 2, '.', ','));   
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"TOTAL GRAVADA 5% : ");
$pdf->setX(18);
$pdf->Cell(0,$textypos,number_format($ventas->total5, 2, '.', ','));   
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"TOTAL GRAVADA 10% : ");
$pdf->setX(18);
$pdf->Cell(0,$textypos,number_format($ventas->total10, 2, '.', ','));   
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"TOTAL I.V.A. 5%: ");
$pdf->setX(18);
$pdf->Cell(0,$textypos,number_format($ventas->iva5, 2, '.', ','));
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"TOTAL I.V.A. 10%: ");
$pdf->setX(18);
$pdf->Cell(0,$textypos,number_format($ventas->iva10, 2, '.', ','));
$textypos+=4;
$pdf->setX(2);
$pdf->Cell(0,$textypos,"TOTAL I.V.A. : ");
$pdf->setX(18);
$pdf->Cell(0,$textypos,number_format($ventas->iva10+$ventas->iva5, 2, '.', ','));
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
$pdf->output();
