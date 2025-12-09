<?php
include "core/autoload.php";
include "core/modules/index/model/ConfigData.php";
include "core/modules/index/model/VentaData.php";
include "core/modules/index/model/OperationData.php";
include "core/modules/index/model/ClienteData.php";
include "core/modules/index/model/VetaReciboData.php";
include "core/modules/index/model/ReciboData.php";
class PDF extends FPDF
{
// Cargar los datos
function LoadData($file)
{

    // Leer las líneas del fichero
}

function Header()
{
   $configuracion = ConfigData::getById("id_empresa");
   $service = VentaData::getById($_GET["id_venta"]);
   $carpetas = VetaReciboData::getAllByTeamId($_GET["id_venta"]); 
        $this->SetFont('Arial','B',5);
        $this->setX(15);
        $this->SetFont('Arial','B',13);
        $this->Cell( 55, 55,"ONLINE RECIBO", 0, 0, 'L', false );

        $this->Image('storage/iconos/logo.png', 60, 18, 20,20, 'png');

        // $this->setY(25);
        // $this->setX(120);
        // $this->Cell(0,10,"storage/admin/$configuracion->logo");
        $this->SetFont('Arial','B',5);
        $this->setX(150);
        $this->SetFont('Arial','B',11);
        $this->Cell( 55, 55,"Bs.....".number_format($service->total-$service->descuento).".....", 0, 0, 'L', false );
        $this->SetFont('Arial','B',5);
        $this->setX(150);
        $this->SetFont('Arial','B',11);
        $this->Cell( 65, 65,"Usd............", 0, 0, 'L', false );
        foreach($carpetas as $operation){
        $product  = $operation->getRecibo();
        $this->Image('storage/recio/'.$product->imagen, 150, 50, 25,25);
        // $this->Image('storage/recio/'.$product->imagen, 150, 50, 25,25, 'https://www.linkedin.com/in/javier-cajahuaman-mallcco-78046812b?originalSubdomain=pe');
        }

        
        $this->Ln();
        $this->setY(7);
        $this->SetFont('Arial','B',10);
        $this->setX(165-5);
}
// Tabla simple
function ImprovedTable($data)
{
    $service = VentaData::getById($_GET["id_venta"]);
    $operations = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
        $this->setY(31);
        $this->setX(60);
        $this->setY(31);
        $this->setX(60);
        $this->SetFont('Arial','B',12);
        $this->setY(33);
        $this->setX(60);
        $this->setY(40);
        $this->setX(60);
        $this->SetFont('Arial','B',12);
        // -----------------------------------------CUERPO-----------------------
        $this->setY(48);
        $this->setX(15);
        $this->Cell(0,10,"He Recibido de: ".$service->getCliente()->nombre." ".$service->getCliente()->apellido);
        $this->setY(58);
        $this->setX(15);
        $this->Cell(0,10,"La Suma de: ".number_format($service->total-$service->descuento)." Bolivariano/Dolares");
        $this->setY(68);
        $this->setX(15);
        $this->Cell(0,10,"Por Concepto de: "." Compra");
        $this->setY(78);
        $this->setX(15);
        $this->Cell(0,10,"                  "."A cuenta: ".".......... "." "."Saldo".".........."." "."Total".number_format($service->total-$service->descuento));
        $this->setY(88);
        $this->setX(15);
        $this->Cell(0,10,"Bolivia: ".$service->fecha);
        $this->setY(128);
        $this->setX(15);
        $this->Cell(0,10,"_______________________________");
        $this->setY(134);
        $this->setX(15);
        $this->Cell(0,10,"              Recibi Conforme ");

        $this->setY(128);
        $this->setX(92);
        $this->Cell(0,10,"_______________________________");
        $this->setY(134);
        $this->setX(92);
        $this->Cell(0,10,"              Entregue Conforme ");     

           

}
}
$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
// $pdf->Header();
$pdf->ImprovedTable("hola");
// imagen - con link
// $pdf->Image('storage/iconos/logo.png', 150, 18, 20,20, 'png', 'https://www.linkedin.com/in/javier-cajahuaman-mallcco-78046812b?originalSubdomain=pe');
// 
//echo $name;
$pdf->Output();
// print "<script>window.location=\"".$name."\";</script>";
?>