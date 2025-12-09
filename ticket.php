<?php
include "core/autoload.php";
include "core/modules/index/model/ConfigData.php";
include "core/modules/index/model/VentaData.php";
include "core/modules/index/model/ClienteData.php";
include "core/modules/index/model/ProductoData.php";
include "core/modules/index/model/OperationData.php";
class PDF extends FPDF
{
// Cargar los datos
function LoadData($file)
{

    // Leer las líneas del fichero
}

function Header()
{
$id_empresa = ConfigData::getById("id_empresa");
    // $service = ProcesosData::getById();
        $this->SetFont('Arial','B',15);
        $this->setX(18);
        $this->SetFont('Arial','B',20);
        $this->Cell( 5, 5, "Delicia Mia", 0, 0, 'L', false );

        $this->Ln();
        $this->setY(7);
        $this->SetFont('Arial','B',10);
        $this->setX(165-5);
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
        $this->setY(12);
        $this->setX(0);
        $this->Cell(0,10,"**********************************************************************************************");
        // ----------------diseño de la Cabecera *********************************
        
        $this->setY(14);
        $this->setX(7);
        $this->Cell(0,10,"Ticket de Venta:");
        $this->setY(14);
        $this->setX(40);
        $this->Cell(0,10,"Numero: ".$service->id_uso);
        $this->setY(18);
        $this->setX(0);
        $this->Cell(0,10,"**********************************************************************************************");
        // *************************************** DISEÑO DE LOS DATOS LA ORGANIZACION
        $this->setY(20);
        $this->setX(2);
        $this->Cell(0,10,"**");
        $this->setY(22);
        $this->setX(2);
        $this->Cell(0,10,"**");
        $this->setY(24);
        $this->setX(2);
        $this->Cell(0,10,"**");
        $this->setY(26);
        $this->setX(2);
        $this->Cell(0,10,"**");
        // $this->setY(28);
        // $this->setX(2);
        // $this->Cell(0,10,"**");
        $this->setY(31);
        $this->setX(2);
        $this->Cell(0,10,"**");
        $this->setY(33);
        $this->setX(2);
        $this->Cell(0,10,"**");
        $this->setY(35);
        $this->setX(2);
        $this->Cell(0,10,"**");
        // -------------------------
        $this->setY(20);
        $this->setX(7);
        $this->Cell(0,10,"DIRECCION");
        $this->setY(24);
        $this->setX(7);
        $this->Cell(0,10,"7mo Anillo Santos");
        $this->setY(27);
        $this->setX(7);
        $this->Cell(0,10,"Dumot C");
        $this->setY(31);
        $this->setX(7);
        $this->Cell(0,10,"Tobochi ");
        $this->setY(35);
        $this->setX(7);
        $this->Cell(0,10,"N. 3");
        $this->setY(20);
        $this->setX(32);
        $this->Cell(0,10,"**");
        $this->setY(22);
        $this->setX(32);
        $this->Cell(0,10,"**");
        $this->setY(24);
        $this->setX(32);
        $this->Cell(0,10,"**");
        $this->setY(26);
        $this->setX(32);
        $this->Cell(0,10,"**");
        $this->setY(28);
        $this->setX(32);
        $this->Cell(0,10,"**");
        $this->setY(30);
        $this->setX(32);
        $this->Cell(0,10,"**");
        $this->setY(32);
        $this->setX(32);
        $this->Cell(0,10,"**");
        $this->setY(34);
        $this->setX(32);
        $this->Cell(0,10,"**");
        // --------------------------------
        $this->setY(20);
        $this->setX(35);
        $this->Cell(0,10,"CONTACTO");
        $this->setY(24);
        $this->setX(35);
        $this->Cell(0,10,"Tel: +591 78439543");
        $this->setY(28);
        $this->setX(35);
        $this->Cell(0,10,"E-mail: alvaro.ch@gmail.com");
        // $this->setY(32);
        // $this->setX(35);
        // $this->Cell(0,10,"RUC: 899341-4");
        $this->setY(28);
        $this->setX(32);
        $this->Cell(0,10,"**");
        $this->setY(30);
        $this->setX(32);
        $this->Cell(0,10,"**");
        $this->setY(32);
        $this->setX(32);
        $this->Cell(0,10,"**");
        $this->setY(34);
        $this->setX(32);
        $this->Cell(0,10,"**");
    // ******************************* CLIENTE  ************************************++
        $this->setY(38);
        $this->setX(7);
        $this->Cell(0,10,"DATOS DEL CLIENTE: ****************************************************************");
        // -----------------------------------
        $this->setY(42);
        $this->setX(7);
        $this->Cell(0,10," NOMBRE:        ".$service->getCliente()->nombre." ".$service->getCliente()->apellido);
        $this->setY(46);
        $this->setX(7);
        $this->Cell(0,10," DNI:        ".$service->getCliente()->dni);
        $this->setY(50);
        $this->setX(7);
        $this->Cell(0,10,"TEL:      ".$service->getCliente()->telefono);
        $this->setY(53);
        $this->setX(20);
        // *********************************************SERVICIOS:****************
        $starty=0;
        $this->setY(55+$starty);
         $this->setX(20);
         $this->setY(55+$starty);
         $this->setX(10);
        foreach($operations as $operation){
        $product  = $operation->getProducto();
        $this->setY(55+$starty);
         $this->setX(7);
         $this->Cell(0,10,strtoupper($operation->q));
         $this->setX(15);
         $this->Cell(0,10,strtoupper($product->nombre));
         $this->setX(50);
         $this->Cell(0,10,('Gs/ '. number_format($product->precio_venta,0,'.','.')));;$total+=$operation->q*$product->precio_venta;
         // $this->setX(80);
         // $this->Cell(0,10,('Gs/ '. number_format($operation->q*$product->precio_venta,0,'.','.')));;$total+=$operation->q*$product->precio_venta;
         $this->setY(55+$starty);
         $this->setX(10);
         $starty+=5;
    }  
     $starty+=5;
         $this->setY(90);
         $this->setX(7);
         $this->Cell(0,10,('Fecha:'));
         $this->setY(90);
         $this->setX(22);
         $this->Cell(0,10,($service->fecha));
         // $this->setY(107);
         // $this->setX(50);
         // $this->Cell(0,10,('**'));
         // $this->setY(109);
         // $this->setX(50);
         // $this->Cell(0,10,('**'));
         // $this->setY(111);
         // $this->setX(50);
         // $this->Cell(0,10,('**'));
         $this->setY(93);
         $this->setX(7);
         $this->Cell(0,10,('Subtotal:'));
         $this->setY(93);
         $this->setX(22);
         $this->Cell(0,10,('Gs/ '. number_format($total,0,'.','.')));
         $this->setY(96);
         $this->setX(7);
         $this->Cell(0,10,('Total:'));
         $this->setY(96);
         $this->setX(22);
         $this->Cell(0,10,(number_format($total- $service->descuento,0,'.','.').' Gs/'));
         $this->setY(110);
         $this->setX(10);
         $this->Cell(0,10,('!  No Valido para Comprobante  Fiscal !'));
}
}
$pdf = new PDF('P','mm','a12');
$pdf->AddPage();
// $pdf->Header();
$pdf->ImprovedTable("hola");

//echo $name;
$pdf->Output();
// print "<script>window.location=\"".$name."\";</script>";
?>