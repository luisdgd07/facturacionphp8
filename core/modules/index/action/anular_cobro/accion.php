<?php
$anular = new CobroDetalleData();
$d2 = $anular->anular($_GET['id']);
$anular2 = new CobroCabecera();
$d = $anular2->anular($_GET['id']);
$operacion = $anular->obtener($_GET['id']);
// var_dump($operacion[0]->NUMERO_CREDITO);

$credito = new CreditoData();
$creditod = new CreditoDetalleData();
// $crd = $credito->anular($operacion[0]->NUMERO_CREDITO);
$monto = CobroCabecera::getCobro($_GET['id']);
$actual = CreditoDetalleData::getByCuota($_GET['cred'], $_GET['cuota']);
$crd2 = $creditod->anular($operacion[0]->NUMERO_CREDITO, $actual->saldo_credito + $monto->TOTAL_COBRO, $_GET['cuota']);
var_dump($actual->saldo_credito);

var_dump($monto->TOTAL_COBRO);
$op = new OperationData();
$op->accion_id = 1;
$op->sucursal_id = $_GET["id_sucursal"];
$op->motivo = 'anulación cobro';
$op->id_cobro = $_GET['id'];
$op->registrotransaccionn2();

Core::alert("Registro anulado  con éxito");
Core::redir("index.php?view=cobros_realizados&id_sucursal=" . $_GET["id_sucursal"]);
// "$this->sucursal_id\",$this->accion_id,$this->venta_id,\"$this->motivo\fix/dev3953