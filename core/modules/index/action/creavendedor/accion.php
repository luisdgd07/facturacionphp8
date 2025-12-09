<?php
$vendedor = new VendedorData();
$vendedor->cedula = $_POST['cedula'];
$vendedor->nombre = $_POST['nombre'];
$vendedor->direccion = $_POST['direccion'];;
$vendedor->id_sucursal = $_POST['id_sucursal'];
$vendedor->crear();







Core::alert("Vendedor registrado correstamente");
$s = $_POST['id_sucursal'];
Core::redir("index.php?view=vended&id_sucursal=$s");
