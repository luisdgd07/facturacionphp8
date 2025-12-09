<?php
include "core/autoload.php";
include "core/modules/index/model/ConfigData.php";
include "core/modules/index/model/VentaData.php";
include "core/modules/index/model/ClienteData.php";
include "core/modules/index/model/ProductoData.php";
include "core/modules/index/model/OperationData.php";
$fech_actual=date("y-m-d H:i:s");
// include "core/modules/index/model/ActividadData.php";
class PDF extends FPDF
{
// Cargar los datos
function LoadData($file)
{

    // Leer las líneas del fichero
}

function Header()
{
}
// Tabla simple
function ImprovedTable($data)
{
    $service = VentaData::getById($_GET["id_uso"]);
    $operations = OperationData::getAllProductsBySellIddd($_GET["id_uso"]);
    $total = 0;
    $totall = 0;
    $this->setY(31);
        $this->setX(20);
        $this->setY(31);
        $this->setX(20);
        $this->SetFont('Arial','B',8);
        $this->setY(33);
        $this->setX(20);
        $this->setY(40);
        $this->setX(20);
        $this->SetFont('Arial','B',8);
//         $this->Cell(0,35,"",1);

        // ----------------diseño

        $this->setY(28);
        $this->setX(150);
        // $this->Cell(0,10," ".$service->id_uso);
        // --------------COPIA ORIGINAL
        $this->setY(32);
        $this->setX(42);
        $this->Cell(0,10,strtoupper(''.$service->fecha));
        $this->setY(35);
        $this->setX(42);
        $this->Cell(0,10,strtoupper("".$service->getCliente()->nombre." ".$service->getCliente()->apellido));
        $this->setY(38);
        $this->setX(42);
        $this->Cell(0,10,strtoupper($service->getCliente()->direccion));
        $this->setY(41);
        $this->setX(42);
        $this->Cell(0,10,strtoupper($service->getCliente()->ciudad));
// -----------------------------------
        $this->setY(32);
        $this->setX(140);
        $this->Cell(0,10,strtoupper('Pago'));
        $this->setY(35);
        $this->setX(140);
        $this->Cell(0,10,strtoupper("".$service->getCliente()->ruc));
        $this->setY(38);
        $this->setX(140);
        $this->Cell(0,10,strtoupper($service->getCliente()->telefono));
        // $this->setY(65);
        $starty=0;
        $this->setY(55+$starty);
         $this->setX(20);
         $this->setY(55+$starty);
         $this->setX(10);
        foreach($operations as $operation){
        $product  = $operation->getProducto();
        $this->setY(55+$starty);
         $this->setX(25);
         $this->Cell(0,10,strtoupper($product->codigo));
         $this->setX(45);
         $this->Cell(0,10,strtoupper($operation->q));
         $this->setX(50);
         $this->Cell(0,10,strtoupper($product->nombre));
         $this->setX(120);
         $this->Cell(0,10,strtoupper('Gs/ '. number_format($product->precio_venta,0,'.','.')));
         $this->setX(160);
         $this->Cell(0,10,strtoupper('Gs/ '. number_format($operation->q*$product->precio_venta,0,'.','.')));;$total+=$operation->q*$product->precio_venta;
         // $this->setY(120);
         // $this->setX(20);
         // $this->Cell(0,10,strtoupper('DESCUENTO'));
         // $this->setY(200);
         // $this->setX(120);
         // $this->Cell(0,10,strtoupper('Gs/. '.$service->descuento));
         
         $this->setY(55+$starty);
         $this->setX(10);
         $starty+=5;
    }  
     $starty+=5;
     $this->setY(120);
         $this->setX(20);
         // $this->Cell(0,10,strtoupper('SUBTOTAL'));
         $this->setY(110);
         $this->setX(168);
         $this->Cell(0,10,strtoupper('Gs/ '.$total));
         $this->setY(125);
         $this->setX(20);
         // $this->Cell(0,10,strtoupper('TOTAL'));
         $this->setY(120);
         $this->setX(160);
         $this->Cell(0,10,strtoupper($total- $service->descuento));
// -----------------------------------FINAL DE COPIA ORIGINAL
// 
// 
// 
// 
// 
// -------************************INICIA LA COPIA******************
        $this->setY(178);
        $this->setX(42);
        $this->Cell(0,10,strtoupper(''.$service->fecha));
        $this->setY(181);
        $this->setX(42);
        $this->Cell(0,10,strtoupper("".$service->getCliente()->nombre." ".$service->getCliente()->apellido));
        $this->setY(184);
        $this->setX(42);
        $this->Cell(0,10,strtoupper($service->getCliente()->direccion));
        $this->setY(187);
        $this->setX(42);
        $this->Cell(0,10,strtoupper($service->getCliente()->ciudad));
// -----------------------------------
        $this->setY(178);
        $this->setX(140);
        $this->Cell(0,10,strtoupper('Pago'));
        $this->setY(181);
        $this->setX(140);
        $this->Cell(0,10,strtoupper("".$service->getCliente()->ruc));
        $this->setY(184);
        $this->setX(140);
        $this->Cell(0,10,strtoupper($service->getCliente()->telefono));
        $starty=0;
        $this->setY(210+$starty);
         $this->setX(20);
         $this->setY(210+$starty);
         $this->setX(10);
        foreach($operations as $operation){
        $product  = $operation->getProducto();
        $this->setY(210+$starty);
         $this->setX(25);
         $this->Cell(0,10,strtoupper($product->codigo));
         $this->setX(45);
         $this->Cell(0,10,strtoupper($operation->q));
         $this->setX(50);
         $this->Cell(0,10,strtoupper($product->nombre));
         $this->setX(120);
         $this->Cell(0,10,strtoupper('Gs/ '. number_format($product->precio_venta,0,'.','.')));
         $this->setX(160);
         $this->Cell(0,10,strtoupper('Gs/ '. number_format($operation->q*$product->precio_venta,0,'.','.')));;$totall+=$operation->q*$product->precio_venta;
         $this->setY(210+$starty);
         $this->setX(10);
         $starty+=5;
    }  
    $starty+=5;
        $this->setY(253);
         $this->setX(20);
         // $this->Cell(0,10,strtoupper('SUBTOTAL'));
         $this->setY(251);
         $this->setX(170);
         $this->Cell(0,10,strtoupper('Gs/ '. number_format($totall,0,'.','.')));
         $this->setY(257);
         $this->setX(20);
         // $this->Cell(0,10,strtoupper('TOTAL'));
         $this->setY(257);
         $this->setX(160);
         $this->Cell(0,10,strtoupper(number_format($totall- $service->descuento,0,'.','.')));
// ----------------*****************FINAL DE COPIA*******************      
}


// Tabla coloreada
}

$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
// $pdf->Header();
$pdf->ImprovedTable("hola");

//echo $name;
$pdf->Output();
// print "<script>window.location=\"".$name."\";</script>";
?>