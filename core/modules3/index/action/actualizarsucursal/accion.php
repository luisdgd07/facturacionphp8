<?php
try {
    $client = new SuccursalData();

    $client->venta_de = $_POST["venta_de"];

    $client->is_facturador = $_POST["is_facturador"];

    $client->nombre = $_POST["nombre"];


    $client->ruc = $_POST["ruc"];

    $client->telefono = $_POST["telefono"];

    $client->representante = $_POST["representante"];
    $client->direccion = $_POST["direccion"];

    $client->descripcion = $_POST["descripcion"];

    $client->id_sucursal = $_POST["id_sucursal"];

    $client->entorno = $_POST["entorno"];
    $client->clave = $_POST["clave"];
    $client->timbrado = $_POST["timbrado"];
    $client->establecimiento = $_POST["establecimiento"];
    $orgDate = $_POST["fecha_firma"];
    // $date = str_replace('-"', '/', $orgDate);
    // $newDate = date("Y/m/d", strtotime($date));
    $client->fecha_firma = $_POST["fecha_firma"];
    $client->razon_social = $_POST["razon_social"];
    $client->nombre_fantasia = $_POST["nombre_fantasia"];
    $client->codigo_act  = $_POST["codigo_act"];
    $client->actividad = $_POST["actividad"];
    $client->fecha_tim = $_POST["fecha_tim"];
    $client->numero_casa = $_POST["numero_casa"];
    $client->com_dir  = $_POST["com_dir"];
    $client->com_dir2 = $_POST["com_dir2"];
    $client->departamento_descripcion = $_POST["departamento_descripcion"];
    $client->distrito_descripcion = $_POST["distrito_descripcion"];
    $client->ciudad_descripcion = $_POST["ciudad_descripcion"];
    $client->id_ciudad = $_POST["id_ciudad"];
    $client->email = $_POST["email"];
    // $client->email = $_POST["email"];
    $client->actualizar();
    echo 1;
} catch (Exception $error) {
    echo 0;
}
