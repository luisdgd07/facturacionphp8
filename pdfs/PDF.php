<?php
/**
 * Clase PDF para Reporte de Ventas (FPDF) — A4 compacto
 */
$ROOT = realpath(__DIR__ . '/..');
require_once $ROOT . '/core/controller/fpdf/fpdf.php';

class VentasPDF extends FPDF
{
    /* ---------------------- Config / estado ---------------------- */
    public $reportTitle    = 'REPORTE DE VENTAS';
    public $reportRange    = '';
    public $reportCompany  = '';   // "Empresa: ..."
    public $reportStatus   = '';
    public $cols           = [];   // ['w'=>mm,'t'=>'T','a'=>'L/C/R']
    public $autoTableHeader = true;

    /* Compactación */
    public $rowH = 5.0;            // alto base de línea
    public $fontData = 8;          // tamaño fuente datos
    public $fontHead = 8;          // tamaño fuente encabezados

    /* Totales de la página */
    public $pageCajas = 0.0;
    public $pageGs    = 0.0;
    public $pageUsd   = 0.0;
    public $pageRows  = 0;

    /* Acumulados entre páginas */
    public $accCajas = 0.0;
    public $accGs    = 0.0;
    public $accUsd   = 0.0;
    public $accRows  = 0;

    /* Layout del pie (reserva espacio) */
    public $footerBlockHeight = 30; // mm

    public function __construct($orientation='P', $unit='mm', $size='A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->SetMargins(10, 12, 10);
        $this->SetAutoPageBreak(true, $this->footerBlockHeight + 12);
        $this->SetDrawColor(0);
        $this->SetTextColor(0);
    }

    /* --------- Compat FPDF antiguos (no traen estos métodos) --------- */
    public function GetPageHeight(){ return $this->h; }
    public function GetPageWidth(){  return $this->w; }

    /* ----------------------------- Header ----------------------------- */
    function Header()
    {
        // Título
        $this->SetFont('Arial','B',22);
        $this->Cell(0,10, self::s($this->reportTitle), 0, 1, 'C');

        // Subtítulos (todos en negrita como pediste)
        if ($this->reportRange || $this->reportCompany || $this->reportStatus) {
            $this->SetFont('Arial','B',11);
            if ($this->reportRange)   $this->Cell(0,6, self::s($this->reportRange), 0, 1, 'C');
            if ($this->reportCompany) $this->Cell(0,6, self::s($this->reportCompany), 0, 1, 'C');
            if ($this->reportStatus)  $this->Cell(0,6, self::s($this->reportStatus), 0, 1, 'C');
        }
        $this->Ln(1);

        // Encabezado de tabla
        if ($this->autoTableHeader && !empty($this->cols)) {
            $this->drawTableHeader();
        }
    }

    /* ----------------------------- Footer ----------------------------- */
    function Footer()
    {
        // Cols del pie: 60 | 28 | 42 | 42 | 18 = 190mm
        $wLabel = 60; $wCajas = 28; $wGs = 42; $wUsd = 42; $wRows = 18;

        $y = $this->GetPageHeight() - ($this->footerBlockHeight + 8);
        $this->SetY($y);

        // Títulos del cuadro
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(235,235,235);
        $this->Cell($wLabel,6,self::s(''),1,0,'L',true);
        $this->Cell($wCajas,6,self::s('Cajas'),1,0,'C',true);
        $this->Cell($wGs,   6,self::s('Total Gs'),1,0,'C',true);
        $this->Cell($wUsd,  6,self::s('Total USD'),1,0,'C',true);
        $this->Cell($wRows, 6,self::s('Regs'),1,1,'C',true);

        // TOTAL PÁGINA
        $this->SetFont('Arial','B',9);
        $this->Cell($wLabel,7,self::s('TOTAL PÁGINA'),1,0,'L');
        $this->SetFont('Arial','',9);
        $this->Cell($wCajas,7,number_format($this->pageCajas,0,',','.'),1,0,'R');
        $this->Cell($wGs,   7,number_format($this->pageGs,   0,',','.'),1,0,'R');
        $this->Cell($wUsd,  7,number_format($this->pageUsd,  2,',','.'),1,0,'R');
        $this->Cell($wRows, 7,number_format($this->pageRows, 0,',','.'),1,1,'R');

        // Acumular
        $this->accCajas += $this->pageCajas;
        $this->accGs    += $this->pageGs;
        $this->accUsd   += $this->pageUsd;
        $this->accRows  += $this->pageRows;

        // ACUMULADO
        $this->SetFont('Arial','B',9);
        $this->Cell($wLabel,7,self::s('ACUMULADO'),1,0,'L');
        $this->SetFont('Arial','',9);
        $this->Cell($wCajas,7,number_format($this->accCajas,0,',','.'),1,0,'R');
        $this->Cell($wGs,   7,number_format($this->accGs,   0,',','.'),1,0,'R');
        $this->Cell($wUsd,  7,number_format($this->accUsd,  2,',','.'),1,0,'R');
        $this->Cell($wRows, 7,number_format($this->accRows, 0,',','.'),1,1,'R');

        // Número de página
        $this->SetY(-8);
        $this->SetFont('Arial','',8);
        $this->Cell(0,6,self::s('Página ').$this->PageNo().'/{nb}',0,0,'R');

        // Reset para próxima hoja
        $this->pageCajas = 0.0; $this->pageGs = 0.0; $this->pageUsd = 0.0; $this->pageRows = 0;
    }

    /* ---------------------- Utilidades ---------------------- */
    public static function s($txt){ return utf8_decode((string)($txt ?? '')); }

    public function drawTableHeader()
    {
        if (empty($this->cols)) return;
        $this->SetFont('Arial','B',$this->fontHead);
        $this->SetFillColor(235,235,235);
        foreach ($this->cols as $c) {
            $w = $c['w'] ?? 20; $t = $c['t'] ?? '';
            // TÍTULO CENTRADO (aunque los datos vayan L/R)
            $this->Cell($w, 6, self::s($t), 1, 0, 'C', true);
        }
        $this->Ln();
    }

    public function Row(array $cells, array $cols = [])
    {
        if (empty($cols)) $cols = $this->cols;
        $n = count($cols); if (!$n) return;

        // calcular alto
        $nb = 1;
        for ($i=0; $i<$n; $i++) {
            $w = $cols[$i]['w'] ?? 20;
            $nb = max($nb, $this->NbLines($w, self::s($cells[$i] ?? '')));
        }
        $h = $this->rowH * $nb;

        // respetar espacio de pie
        $bottom = $this->GetPageHeight() - ($this->footerBlockHeight + 12);
        if ($this->GetY() + $h > $bottom) {
            $this->AddPage();
        }

        // pintar fila
        $x = $this->GetX(); $y = $this->GetY();
        $this->SetFont('Arial','',$this->fontData);

        for ($i=0; $i<$n; $i++) {
            $w = $cols[$i]['w'] ?? 20; $a = $cols[$i]['a'] ?? 'L';
            $txt = self::s($cells[$i] ?? '');
            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, $this->rowH, $txt, 0, $a);
            $x += $w; $this->SetXY($x, $y);
        }
        $this->Ln($h);
    }

    protected function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w==0) $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',$txt); $nb = strlen($s);
        if ($nb>0 && $s[$nb-1]=="\n") $nb--;
        $sep=-1; $i=0; $j=0; $l=0; $nl=1;
        while($i<$nb){
            $c=$s[$i];
            if($c=="\n"){ $i++; $sep=-1; $j=$i; $l=0; $nl++; continue; }
            if($c==' ') $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax){ if($sep==-1){ if($i==$j) $i++; } else { $i=$sep+1; }
                $sep=-1; $j=$i; $l=0; $nl++; }
            else { $i++; }
        }
        return $nl;
    }
}

