<?php
$agente = new AgenteData();
$agente->telefono = $_POST['telefono'];
$agente->nombre_agente = $_POST['nombre_agente'];
$agente->direccion = $_POST['direccion'];;
$agente->id_sucursal = $_POST['id_sucursal'];
$agente->ruc = $_POST['ruc'];
$agente->crear();


Core::alert("Agente registrado");
$s = $_POST['id_sucursal'];
Core::redir("index.php?view=agente&id_sucursal=$s");
