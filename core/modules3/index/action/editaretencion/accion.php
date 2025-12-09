<?php
$retc = new RetencionData();
$retd = new RetencionDetalleData();
$retc->id = $_POST['id'];
$retc->ret = $_POST['ret'];
$retc->fecha = $_POST['fecha'];
$r1 = $retc->editar();
$retd->id = $_POST['id'];
$retd->ret = $_POST['ret'];
$retd->fecha = $_POST['fecha'];
$retd->timbrado = $_POST['timbrado'];
$r2 = $retd->editar();
var_dump($r1);
var_dump($r2);
// index.php?view=listaretenciones&id_sucursal=17
Core::redir("index.php?view=listaretenciones&id_sucursal=" . $_POST["id_sucursal"]);
