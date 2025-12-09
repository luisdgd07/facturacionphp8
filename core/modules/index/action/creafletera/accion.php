<?php
$fletera = new FleteraData();
$fletera->telefono = $_POST['telefono'];
$fletera->nombre = $_POST['nombre'];
$fletera->direccion = $_POST['direccion'];;
$fletera->sucursal = $_POST['id_sucursal'];
$fletera->ruc = $_POST['ruc'];
$fletera->crear();


Core::alert("Empresa fletera registrada");
$s = $_POST['id_sucursal'];
Core::redir("index.php?view=fletera&id_sucursal=$s");
