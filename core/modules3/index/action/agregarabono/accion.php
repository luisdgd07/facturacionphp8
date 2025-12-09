<?php
$creditoDetalle = new CreditoDetalleData();
$creditoDetalle->agregar_abono($_POST['monto'], $_POST['id']);
$credito = new CreditoData();
$credito->agregar_abono($_POST['monto'], $_POST['id_venta']);
print "<script> window.history.back();</script>";
