<?php
$dncp = new DNCPData();
$agno = date("Y");
$dos_ultimos = substr($agno, -2);
$dncp->id_sucursal = $_POST["sucursal_id"];
$dncp->modalidad = $_POST["modalidad"];
$dncp->entidad = $_POST["entidad"];
$dncp->fecha = $_POST["fecha"];
$dncp->secuencia = $_POST["secuencia"];
$dncp->agno = $dos_ultimos;
$dncp->cliente_id = $_POST["cliente_id"];

$dncp->crear();
Core::alert("DNCP registrado");
$s = $_POST['sucursal_id'];
Core::redir("index.php?view=nuevodncp&id_sucursal=$s");
