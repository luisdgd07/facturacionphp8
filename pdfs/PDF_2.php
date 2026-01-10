<?php
include "../CifrasEnLetras.php";
include "../core/autoload.php";
include "../core/modules/index/model/VentaData.php";
include "../core/modules/index/model/SuccursalData.php";
include "../core/modules/index/model/SucursalUusarioData.php";
include "../core/modules/index/model/UserData.php";
include "../core/modules/index/model/ProveedorData.php";
include "../core/modules/index/model/ClienteData.php";
include "../core/modules/index/model/AccionData.php";
include "../core/modules/index/model/MonedaData.php";
include "../core/modules/index/model/OperationData.php";
include "../core/modules/index/model/ConfigFacturaData.php";
include "../core/modules/index/model/ProductoData.php";
include "../core/modules/index/model/StockData.php";
include "../core/modules/index/model/CobroCabecera.php";
include "../core/modules/index/model/CobroDetalleData.php";
include "../core/modules/index/model/CajaCabecera.php";
include "../core/modules/index/model/CajaDetalle.php";
include "../core/modules/index/model/RetencionDetalleData.php";
include "../core/modules/index/model/CreditoDetalleData.php";
$pdf = new FPDF('P', 'mm', 'A4');
class PDF extends FPDF
{
    function Header()
    {
        $this->SetY(0);
        $DateAndTime = date('d-m-Y h:i:s a', time());
        // echo " Fecha: $DateAndTime.";
        $sucur = SuccursalData::VerId($_GET["id_sucursal"]);
        $this->SetFont('Arial', 'I', 6);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 10,  $DateAndTime, 0, 0, 'C');
        $this->Ln(7);
        $this->Ln(3);
        $this->Cell(0, 10, 'Fecha:' . $DateAndTime, 0, 0, 'C');
        if (!is_null($sucur->logo)) {
            $this->Image('../' . $sucur->logo, 70, 10, 65, 28, "PNG");
        }
        $this->SetFont('Arial', 'I', 13);

        $this->Ln(7);
        $this->SetY(35);
        $this->Cell(0, 10, $this->title, 0, 0, 'C');
        $this->SetY(45);
        $this->Cell(0, 10, $sucur->nombre, 0, 0, 'C');
        $this->SetY(60);
        $this->SetFont('Arial', 'I', 6);
    }

    function imprimirReporte($cols, $width, $rows, $tabla = false)
    {
        $this->AddPage();
        $i = 0;
        // if (!$tabla) {
        //     foreach ($cols as $col) {
        //         $this->Cell($width[$i], 7, $col, 1);
        //         $i++;
        //     }
        // }

        $k = 0;

        foreach ($rows as $row) {
            $j = 0;
            $this->Ln(4.3);

            if ($k % 40 == 0 && $k != 0 && $tabla) {
                $this->AddPage();
                $i = 0;
                foreach ($cols as $col) {
                    $this->Cell($width[$i], 4.3, $col, 1);
                    $i++;
                }
                $this->Ln(4.3);
            }
            $k++;
            foreach ($row as $r) {
                // if ($k % 30) {

                $this->Cell($width[$j], 4.3, $r, 1);

                // } else {
                //     $this->Cell($width[$j], 7, $r, 1);

                //     $j++;
                // }
                $j += 1;
            }
        }
    }
    //Pie de página
    // function Footer()
    // {
    //     //Posición: a 1,5 cm del final
    //     $this->SetY(-15);
    //     //Arial italic 8
    //     $this->SetFont('Arial', 'I', 8);
    //     //Número de página
    //     $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    // }

    // function SetCol($col)
    // {
    //     //Establecer la posición de una columna dada
    //     $this->col = $col;
    //     $x = 10 + $col * 75;
    //     $this->SetLeftMargin($x);
    //     $this->SetX($x);
    // }

    // function AcceptPageBreak()
    // {
    //     //Método que acepta o no el salto automático de página
    //     if ($this->col < 2) {
    //         //Ir a la siguiente columna
    //         $this->SetCol($this->col + 1);
    //         //Establecer la ordenada al principio
    //         $this->SetY($this->y0);
    //         //Seguir en esta página
    //         return false;
    //     } else {
    //         //Volver a la primera columna
    //         $this->SetCol(0);
    //         //Salto de página
    //         return true;
    //     }
    // }

    // function TituloArchivo($num, $label)
    // {
    //     $this->SetY(55);
    //     $this->SetFont('Arial', '', 12);
    //     $this->SetFillColor(200, 220, 255);
    //     $this->Cell(0, 6, "Archivo $num : $label", 0, 1, 'L', true);
    //     $this->Ln(4);
    //     //Guardar ordenada
    //     $this->y0 = $this->GetY();
    // }

    // function CuerpoArchivo($file)
    // {
    //     //Leemos el fichero
    //     $f = fopen($file, 'r');
    //     $txt = fread($f, filesize($file));
    //     fclose($f);
    //     //Times 12
    //     $this->SetFont('Times', '', 12);
    //     //Imprimimos el texto justificado
    //     $this->MultiCell(60, 5, $txt);
    //     //Salto de línea
    //     $this->Ln();
    //     //Volver a la primera columna
    //     $this->SetCol(0);
    // }
    function cabecera($logo)
    {
        // $this->AddPage();
        // $this->TituloArchivo($num, $title);
        // $this->CuerpoArchivo($file);
    }
    // function ImprimirArchivo($num, $title, $file)
    // {
    //     $this->AddPage();
    //     $this->TituloArchivo($num, $title);
    //     $this->CuerpoArchivo($file);
    // }
}
