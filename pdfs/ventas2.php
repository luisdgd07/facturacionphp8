<?php
/* ======================= DEBUG & LOG ======================= */
$DEBUG = isset($_GET['debug']) && $_GET['debug'] == '1';

@ini_set('display_errors', $DEBUG ? '1' : '0');  // pantalla sólo si ?debug=1
@ini_set('log_errors', '1');
@ini_set('memory_limit', '512M');
@set_time_limit(180);
if (function_exists('date_default_timezone_set')) @date_default_timezone_set('America/Asuncion');

$LOG_APP = __DIR__.'/.ventas_error.log';   // log propio del reporte
$LOG_PHP = __DIR__.'/.ventas_php.log';     // error_log de PHP
@ini_set('error_log', $LOG_PHP);

function vlog($msg){
  global $LOG_APP;
  $line = '['.gmdate('Y-m-d H:i:s')." UTC] ".$msg."\n";
  @file_put_contents($LOG_APP, $line, FILE_APPEND);
}

set_error_handler(function($errno, $errstr, $errfile, $errline){
  if ($errno === E_DEPRECATED || $errno === E_USER_DEPRECATED) {
    vlog("PHP DEPRECATED [$errno] $errstr at $errfile:$errline");
    return true;
  }
  vlog("PHP ERROR [$errno] $errstr at $errfile:$errline");
  return false;
});

set_exception_handler(function($ex){
  vlog("UNCAUGHT EXCEPTION: ".$ex->getMessage()."\n".$ex->getTraceAsString());
  if (!headers_sent()) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
  }
  echo "Error interno en ventas2.php\n";
  echo "Revise logs: .ventas_error.log y .ventas_php.log\n";
  if (isset($_GET['debug']) && $_GET['debug']=='1') {
    echo "\nEXCEPTION: ".$ex->getMessage()."\n".$ex->getTraceAsString();
  }
  exit;
});

register_shutdown_function(function(){
  $e = error_get_last();
  if ($e && in_array($e['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
    vlog("FATAL: {$e['message']} in {$e['file']}:{$e['line']}");
    if (!headers_sent()) {
      http_response_code(500);
      header('Content-Type: text/plain; charset=utf-8');
      echo "Se produjo un error fatal.\n";
      echo "Revise logs: .ventas_error.log y .ventas_php.log\n";
    }
  }
});

/* ---------- helpers ---------- */
function pfloat($v){ return ($v === null || $v === '') ? 0.0 : (float)$v; }
function mapTipoDoc($t){
  $t=(int)$t; if($t===0||$t===5) return 'FACTURA';
  if($t===4) return 'REMISION'; if($t===15) return 'NOTA CREDITO'; if($t===20) return 'EXPORTACION'; return '—';
}
function whereTipoVenta($tipofactura){
  if ($tipofactura==='ventas') return " AND v.tipo_venta IN (0,5) ";
  if ($tipofactura==='4') return " AND v.tipo_venta = 4 ";
  if ($tipofactura==='15') return " AND v.tipo_venta = 15 ";
  if ($tipofactura==='20') return " AND v.tipo_venta = 20 ";
  return "";
}
function sumCajasByVenta($idVenta){
  $id=(int)$idVenta;
  $sql="SELECT COALESCE(SUM(q),0) AS cajas FROM operacion WHERE venta_id={$id}";
  $res=Executor::doit($sql);
  if ($res && isset($res[0]) && $res[0]) { $r=$res[0]->fetch_assoc(); return (float)($r['cajas']??0); }
  return 0.0;
}

/* ---------- core & modelos ---------- */
$ROOT = realpath(__DIR__ . '/..');
require_once $ROOT . '/core/controller/Database.php';
require_once $ROOT . '/core/controller/Executor.php';
require_once $ROOT . '/core/controller/Model.php';

require_once $ROOT . '/core/modules/index/model/ClienteData.php';
require_once $ROOT . '/core/modules/index/model/VendedorData.php';
require_once $ROOT . '/core/modules/index/model/MonedaData.php';
require_once $ROOT . '/core/modules/index/model/OperationData.php';
require_once $ROOT . '/core/modules/index/model/SuccursalData.php';
require_once $ROOT . '/core/modules/index/model/VentaData.php';

require_once __DIR__ . '/PDF.php';

/* ---------- parámetros ---------- */
$sd  = $_GET['sd']  ?? date('Y-m-d');
$ed  = $_GET['ed']  ?? date('Y-m-d');
$prod = trim($_GET['prod'] ?? 'Aprobado');
$tipofactura = trim($_GET['tipofactura'] ?? ($_GET['venta'] ?? 'ventas'));
$id_sucursal = trim($_GET['id_sucursal'] ?? 'todos');
$clienteSel  = trim($_GET['cliente']     ?? 'todos');
$vendedorSel = trim($_GET['vendedor']    ?? 'todos');
$monedaSel   = trim($_GET['moneda']      ?? 'todos');

vlog('PARAMS '.json_encode([
  'sd'=>$sd,'ed'=>$ed,'prod'=>$prod,'tipofactura'=>$tipofactura,
  'id_sucursal'=>$id_sucursal,'cliente'=>$clienteSel,'vendedor'=>$vendedorSel,'moneda'=>$monedaSel
]));

/* ---------- filtros ---------- */
$where = " WHERE v.fecha BETWEEN '{$sd}' AND '{$ed}' ";
if ($prod==='Aprobado')      $where .= " AND v.enviado='Aprobado' ";
elseif ($prod==='Rechazado') $where .= " AND v.enviado='Rechazado' ";
if ($id_sucursal!=='todos')  $where .= " AND v.sucursal_id=".intval($id_sucursal)." ";
if ($clienteSel!=='todos')   $where .= " AND v.cliente_id=".intval($clienteSel)." ";
if ($vendedorSel!=='todos')  $where .= " AND v.vendedor=".intval($vendedorSel)." ";
if ($monedaSel!=='todos')    $where .= " AND v.tipomoneda_id=".intval($monedaSel)." ";
$where .= whereTipoVenta($tipofactura);

/* ---------- SQL ---------- */
$sql = "
  SELECT v.id_venta, v.fecha, v.factura, v.total, v.cambio2, v.enviado,
         v.metodopago, v.tipo_venta, v.tipomoneda_id, v.cliente_id, v.vendedor, v.sucursal_id
  FROM venta v
  {$where}
  ORDER BY v.fecha ASC, v.id_venta ASC
";
vlog("SQL:\n".$sql);

$q = Executor::doit($sql);
if (!$q || !isset($q[0]) || $q[0]===false) {
  $err = method_exists('Database','getCon') ? Database::getCon()->error : '(sin detalle)';
  vlog("SQL ERROR: ".$err);
  if (!headers_sent()) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
  }
  echo "No se pudo generar el PDF (error SQL).\n";
  echo "Detalle: ".($DEBUG ? $err."\n\nConsulta:\n".$sql : "Active ?debug=1 o revise .ventas_error.log");
  exit;
}
$rs = $q[0];

/* ---------- PDF ---------- */
// Preparar PDF y cabecera **antes** del AddPage
$pdf = new VentasPDF('P','mm','A4');
$pdf->AliasNbPages();

$pdf->reportTitle   = 'REPORTE DE VENTAS';
$pdf->reportRange   = "Rango: {$sd} a {$ed}";
$pdf->reportStatus  = "Estado: ".($prod ?: 'Todos');

/* Empresa desde Sucursal */
$empresaTxt = 'Empresa: Todas las sucursales';
if ($id_sucursal !== 'todos' && class_exists('SuccursalData') && method_exists('SuccursalData','VerId')) {
  $suc = SuccursalData::VerId(intval($id_sucursal));
  if ($suc) {
    $nombre = '';
    if (isset($suc->nombre) && $suc->nombre) $nombre = $suc->nombre;
    elseif (isset($suc->name) && $suc->name) $nombre = $suc->name;
    if ($nombre) $empresaTxt = 'Empresa: '.$nombre;
  }
}
$pdf->reportCompany = $empresaTxt;

/* Columnas COMPACTAS — total 190mm */
$cols = [
  ['w'=>17, 't'=>'Fecha',     'a'=>'L'],
  ['w'=>36, 't'=>'Cliente',   'a'=>'L'],
  ['w'=>25, 't'=>'Factura',   'a'=>'L'],
  ['w'=>13, 't'=>'Cambio',    'a'=>'R'],
  ['w'=>10, 't'=>'Cajas',     'a'=>'R'],
  ['w'=>20, 't'=>'Total Gs',  'a'=>'R'],
  ['w'=>21, 't'=>'Total USD', 'a'=>'R'],
  ['w'=>17, 't'=>'Método',    'a'=>'L'],
  ['w'=>17, 't'=>'Vendedor',  'a'=>'L'],
  ['w'=>8,  't'=>'Mon.',       'a'=>'L'],
  ['w'=>6,  't'=>'Tipo',      'a'=>'L'],
]; // 17+37+24+12+12+20+22+14+14+10+8 = 190
$pdf->cols = $cols;

/* Tipografía y altura compactas */
$pdf->fontHead = 8;
$pdf->fontData = 8;
$pdf->rowH     = 5.0;

$pdf->AddPage();

/* Init contadores para el pie */
$pdf->pageCajas=0.0; $pdf->pageGs=0.0; $pdf->pageUsd=0.0; $pdf->pageRows=0;
$pdf->accCajas=0.0;  $pdf->accGs=0.0;  $pdf->accUsd=0.0;  $pdf->accRows=0;

/* ---------- loop ---------- */
while ($row = $rs->fetch_assoc()) {
  $idVenta   = (int)$row['id_venta'];
  $fecha     = $row['fecha'];
  $factura   = (string)$row['factura'];
  $total     = pfloat($row['total']);
  $cambio    = pfloat($row['cambio2']);
  $metodo    = strtoupper($row['metodopago'] ?? '');
  $tipoDoc   = mapTipoDoc($row['tipo_venta']);
  $idMoneda  = (int)$row['tipomoneda_id'];
  $idCliente = (int)$row['cliente_id'];
  $idVend    = (int)$row['vendedor'];

  // Nombres
  $clienteNombre = '';
  if ($idCliente && class_exists('ClienteData') && method_exists('ClienteData','getById')) {
    $cli = ClienteData::getById($idCliente);
    if ($cli) $clienteNombre = $cli->name ?? $cli->nombre ?? '';
  }
  $vendedorNombre = '';
  if ($idVend && class_exists('VendedorData') && method_exists('VendedorData','getById')) {
    $vend = VendedorData::getById($idVend);
    if ($vend && isset($vend->nombre)) $vendedorNombre = $vend->nombre;
  }
  $monedaNombre = '';
  if ($idMoneda && class_exists('MonedaData') && method_exists('MonedaData','vermonedaid')) {
    $m = MonedaData::vermonedaid($idMoneda);
    if ($m && isset($m->nombre)) $monedaNombre = strtoupper($m->nombre); // DOLARES / GUARANIES
  }

  // Cajas desde operacion.q
  if (class_exists('OperationData') && method_exists('OperationData','sumQuantityBySellId')) {
    $cajas = (float) OperationData::sumQuantityBySellId($idVenta);
  } else {
    $cajas = sumCajasByVenta($idVenta);
  }

  // Distribución por moneda hacia columnas de totales
  $outGs=0.0; $outUsd=0.0;
  if ($monedaNombre === 'DOLARES') $outUsd = $total;
  elseif ($monedaNombre==='GUARANIES' || $monedaNombre==='GUARANÍES') $outGs = $total;
  else { if ($cambio>0) $outUsd=$total/$cambio; else $outGs=$total; }

  // Moneda visible corta
  $monedaOut = ($monedaNombre === 'DOLARES') ? 'USD'
             : (($monedaNombre==='GUARANIES' || $monedaNombre==='GUARANÍES') ? 'GS' : $monedaNombre);

  // Tipo visible corto
  $tipoOut = $tipoDoc;
  if ($tipoDoc === 'FACTURA')        $tipoOut = 'F';
  elseif ($tipoDoc === 'NOTA CREDITO') $tipoOut = 'NC';
  elseif ($tipoDoc === 'REMISION')     $tipoOut = 'R';
  elseif ($tipoDoc === 'EXPORTACION')  $tipoOut = 'EXP';

  // Fila
  $fila = [
    $fecha,
    $clienteNombre,
    $factura,
    number_format($cambio,2,',','.'),   // <<< 2 decimales
    number_format($cajas,0,',','.'),
    number_format($outGs,0,',','.'),
    number_format($outUsd,2,',','.'),
    $metodo,
    $vendedorNombre,
    $monedaOut,
    $tipoOut,
  ];
  $pdf->Row($fila, $cols);

  // Sumas para el pie
  $pdf->pageCajas += $cajas;
  $pdf->pageGs    += $outGs;
  $pdf->pageUsd   += $outUsd;
  $pdf->pageRows  += 1;
}

/* ---------- salida ---------- */
if (!headers_sent()) {
  header('Content-Type: application/pdf');
  header('Cache-Control: private, max-age=0, must-revalidate');
}
if (function_exists('ob_get_length') && ob_get_length()) { @ob_end_clean(); }
$pdf->Output('REPORTE_VENTAS.pdf','I');
exit;

