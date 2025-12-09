<?php

    $accion = $_POST["accion"];

    if($accion == 'obtenerRuc'){
        $sucursal = $_POST["sucursal"];
        echo json_encode(ReporteData::obtenerRuc($sucursal));
    }else if($accion == 'reporte'){
        $sucursal = $_POST["sucursal"];
        $fechaInicio = $_POST["txtFechaDesde"];
        $fechaFin = $_POST["txtFechaHasta"];
        $tipoReporte = $_POST["tipoReporte"];
        $monedaPrincipal = $_POST["monedaPrincipal"];
        $monedaSeleccionada = $_POST["monedaSeleccionada"];
        if($tipoReporte == "reporte_venta"){
            echo json_encode(ReporteData::buscarDatosReporte90Venta($fechaInicio,$fechaFin,$sucursal, $monedaPrincipal, $monedaSeleccionada));
        }else if($tipoReporte == "reporte_compra"){
            echo json_encode(ReporteData::buscarDatosReporte90Compra($fechaInicio,$fechaFin,$sucursal, $monedaPrincipal, $monedaSeleccionada));
        }
    }

?>