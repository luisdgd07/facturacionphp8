<?php
$dncp = new DNCPData();
$agno = date("Y");
$dos_ultimos = substr($agno, -2);
$dncp->id = $_POST["id"];
$dncp->id_sucursal = $_POST["sucursal_id"];
$dncp->modalidad = $_POST["modalidad"];
$dncp->entidad = $_POST["entidad"];
$dncp->fecha = $_POST["fecha"];
$dncp->secuencia = $_POST["secuencia"];
$dncp->agno = $dos_ultimos;
$dncp->cliente_id = $_POST["cliente_id"];

$dncp->actualizar1();
Core::alert("DNCP actualizado con éxito");
$s = $_POST['sucursal_id'];
Core::redir("index.php?view=listadncp&id_sucursal=$s");
