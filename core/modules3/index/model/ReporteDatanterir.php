<?php

class ReporteData {

    public static function obtenerRuc($sucursalId){
        $sql = "SELECT SUBSTRING_INDEX(ruc,'-',1) as ruc FROM sucursal where id_sucursal = $sucursalId";
        $query = Executor::doit($sql);
        return Model::many($query[0],new ReporteData());
    }

    public static function buscarDatosReporte90Venta($fechaDesde, $fechaHasta, $sucursal, $monedaPrincipal, $monedaSeleccionada){
        if($monedaPrincipal == "US$"){
            if($monedaSeleccionada == "₲"){
                $sql = "select 
                1 as tipoArchivo, 
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 15
                    when c.tipo_doc = 'CI' THEN 12
                    when c.tipo_doc = 'RUC' THEN 11
                    when c.tipo_doc = 'CEDULA EXTRANJERO' THEN 14
                    when c.tipo_doc = 'DIPLOMATICO' THEN 16
                    when c.tipo_doc = 'PASAPORTE' THEN 13
                    when c.tipo_doc = 'IDENTIFICACION TRIBUTARIA' THEN 17
                end as ruc,
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 'X'
                    else SUBSTRING_INDEX(c.dni,'-',1)
                end as ss,
                '' as nombre,
                109 as factura,
                date_format(v.fecha, '%d/%m/%Y') as fecha, -- pendiente
                c2.timbrado1 as timbrado,
                v.factura as fact,
                ifnull(ROUND(((v.total10 + v.iva10) * (select valor from tipomoneda where simbolo = '₲' and sucursal_id = $sucursal)),'.'),0) as MontoGravado10,
                ifnull(ROUND(((v.total5 + v.iva5) * (select valor from tipomoneda where simbolo = '₲' and sucursal_id = $sucursal)),'.'),0) as MontoGravado5,
                v.exenta as exento,
                ifnull(ROUND(((v.total) * (select valor from tipomoneda where simbolo = '₲' and sucursal_id = $sucursal)),'.'),0) as total,
                CASE
                    when v.metodopago = 'Contado' THEN 1
                    when v.metodopago = 'Credito' then 2
                end as metodocompra,
                'N' as nro_operacion,
                'S' as inputaIVA,
                'N' as inputaIRE,
                'N' as inputaIRP,
                '' as NroComprobanteAsociado,
                '' as TimbradoComprobanteAsociado
                from venta v
                left join cliente c on c.id_cliente = v.cliente_id
                left join configfactura c2 on  c2.id_configfactura =v.configfactura_id
                where v.sucursal_id = $sucursal and v.fecha between '$fechaDesde' and '$fechaHasta' and v.accion_id = 2 and v.tipo_venta != 2";
            }else{
                $sql = "select 
                1 as tipoArchivo, 
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 15
                    when c.tipo_doc = 'CI' THEN 12
                    when c.tipo_doc = 'RUC' THEN 11
                    when c.tipo_doc = 'CEDULA EXTRANJERO' THEN 14
                    when c.tipo_doc = 'DIPLOMATICO' THEN 16
                    when c.tipo_doc = 'PASAPORTE' THEN 13
                    when c.tipo_doc = 'IDENTIFICACION TRIBUTARIA' THEN 17
                end as ruc,
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 'X'
                    else SUBSTRING_INDEX(c.dni,'-',1)
                end as ss,
                '' as nombre,
                109 as factura,
                date_format(v.fecha, '%d/%m/%Y') as fecha, -- pendiente
                c2.timbrado1 as timbrado,
                v.factura as fact,
                ifnull(ROUND(((v.total10 + v.iva10)),'.'),0) as MontoGravado10,
                ifnull(ROUND(((v.total5 + v.iva5)),'.'),0) as MontoGravado5,
                v.exenta as exento,
                ifnull(ROUND(((v.total)),'.'),0) as total,
                CASE
                    when v.metodopago = 'Contado' THEN 1
                    when v.metodopago = 'Credito' then 2
                end as metodocompra,
                'N' as nro_operacion,
                'S' as inputaIVA,
                'N' as inputaIRE,
                'N' as inputaIRP,
                '' as NroComprobanteAsociado,
                '' as TimbradoComprobanteAsociado
                from venta v
                left join cliente c on c.id_cliente = v.cliente_id
                left join configfactura c2 on  c2.id_configfactura =v.configfactura_id
                where v.sucursal_id = $sucursal and v.fecha between '$fechaDesde' and '$fechaHasta' and v.accion_id = 2 and v.tipo_venta != 2";
            }
        }else if($monedaPrincipal == "₲"){
            if($monedaSeleccionada == "US$"){
                $sql = "select 
                1 as tipoArchivo, 
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 15
                    when c.tipo_doc = 'CI' THEN 12
                    when c.tipo_doc = 'RUC' THEN 11
                    when c.tipo_doc = 'CEDULA EXTRANJERO' THEN 14
                    when c.tipo_doc = 'DIPLOMATICO' THEN 16
                    when c.tipo_doc = 'PASAPORTE' THEN 13
                    when c.tipo_doc = 'IDENTIFICACION TRIBUTARIA' THEN 17
                end as ruc,
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 'X'
                    else SUBSTRING_INDEX(c.dni,'-',1)
                end as ss,
                '' as nombre,
                109 as factura,
                date_format(v.fecha, '%d/%m/%Y') as fecha, -- pendiente
                c2.timbrado1 as timbrado,
                v.factura as fact,
                ifnull(ROUND(((v.total10 + v.iva10) / (select valor from tipomoneda where simbolo = '$monedaPrincipal' and sucursal_id = $sucursal)),'.'),0) as MontoGravado10,
                ifnull(ROUND(((v.total5 + v.iva5) / (select valor from tipomoneda where simbolo = '$monedaPrincipal' and sucursal_id = $sucursal)),'.'),0) as MontoGravado5,
                v.exenta as exento,
                ifnull(ROUND(((v.total) / (select valor from tipomoneda where simbolo = '$monedaPrincipal' and sucursal_id = $sucursal)),'.'),0) as total,
                CASE
                    when v.metodopago = 'Contado' THEN 1
                    when v.metodopago = 'Credito' then 2
                end as metodocompra,
                'N' as nro_operacion,
                'S' as inputaIVA,
                'N' as inputaIRE,
                'N' as inputaIRP,
                '' as NroComprobanteAsociado,
                '' as TimbradoComprobanteAsociado
                from venta v
                left join cliente c on c.id_cliente = v.cliente_id
                left join configfactura c2 on  c2.id_configfactura =v.configfactura_id
                where v.sucursal_id = $sucursal and v.fecha between '$fechaDesde' and '$fechaHasta' and v.accion_id = 2 and v.tipo_venta != 2";
            }else{
                $sql = "select 
                1 as tipoArchivo, 
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 15
                    when c.tipo_doc = 'CI' THEN 12
                    when c.tipo_doc = 'RUC' THEN 11
                    when c.tipo_doc = 'CEDULA EXTRANJERO' THEN 14
                    when c.tipo_doc = 'DIPLOMATICO' THEN 16
                    when c.tipo_doc = 'PASAPORTE' THEN 13
                    when c.tipo_doc = 'IDENTIFICACION TRIBUTARIA' THEN 17
                end as ruc,
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 'X'
                    else SUBSTRING_INDEX(c.dni,'-',1)
                end as ss,
                '' as nombre,
                109 as factura,
                date_format(v.fecha, '%d/%m/%Y') as fecha, -- pendiente
                c2.timbrado1 as timbrado,
                v.factura as fact,
                ifnull(ROUND(((v.total10 + v.iva10)),'.'),0) as MontoGravado10,
                ifnull(ROUND(((v.total5 + v.iva5)),'.'),0) as MontoGravado5,
                v.exenta as exento,
                ifnull(ROUND(((v.total)),'.'),0) as total,
                CASE
                    when v.metodopago = 'Contado' THEN 1
                    when v.metodopago = 'Credito' then 2
                end as metodocompra,
                'N' as nro_operacion,
                'S' as inputaIVA,
                'N' as inputaIRE,
                'N' as inputaIRP,
                '' as NroComprobanteAsociado,
                '' as TimbradoComprobanteAsociado
                from venta v
                left join cliente c on c.id_cliente = v.cliente_id
                left join configfactura c2 on  c2.id_configfactura =v.configfactura_id
                where v.sucursal_id = $sucursal and v.fecha between '$fechaDesde' and '$fechaHasta' and v.accion_id = 2 and v.tipo_venta != 2";
            }
        }
        
        $query = Executor::doit($sql);
        return Model::many($query[0],new ReporteData());
    }

    public static function buscarDatosReporte90Compra($fechaDesde, $fechaHasta, $sucursal, $monedaPrincipal, $monedaSeleccionada){

		if($monedaPrincipal == "US$"){
            if($monedaSeleccionada == "₲"){
                $sql = "select 
                2 as tipoArchivo, 
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 15
                    when c.tipo_doc = 'CI' THEN 12
                    when c.tipo_doc = 'RUC' THEN 11
                    when c.tipo_doc = 'CEDULA EXTRANJERO' THEN 14
                    when c.tipo_doc = 'DIPLOMATICO' THEN 16
                    when c.tipo_doc = 'PASAPORTE' THEN 13
                    when c.tipo_doc = 'IDENTIFICACION TRIBUTARIA' THEN 17
                end as ruc,
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 'X'
                    else SUBSTRING_INDEX(c.dni,'-',1)
                end as ss,
                '' as nombre,
                109 as factura,
                date_format(v.fecha, '%d/%m/%Y') as fecha, -- pendiente
                v.timbrado2 as timbrado,
                v.comprobante2 as fact,
                ifnull(ROUND(((v.grabada102 + v.iva102) * (select valor2 from tipomoneda where simbolo = '$monedaPrincipal' and sucursal_id = $sucursal)),'.'),0) as MontoGravado10,
                ifnull(ROUND(((v.grabada52 + v.iva52) * (select valor2 from tipomoneda where simbolo = '$monedaPrincipal' and sucursal_id = $sucursal)),'.'),0) as MontoGravado5,
                v.excenta2 as exento,
                ifnull(ROUND(((v.total) * (select valor2 from tipomoneda where simbolo = '$monedaPrincipal' and sucursal_id = $sucursal)),'.'),0) as total,
                CASE
                    when v.condicioncompra2 = 'Contado' THEN 1
                    when v.condicioncompra2 = 'Credito' then 2
                end as metodocompra,
                'N' as nro_operacion,
                'S' as inputaIVA,
                'N' as inputaIRE,
                'N' as inputaIRP,
				'N' as imputa,
                '' as NroComprobanteAsociado,
                '' as TimbradoComprobanteAsociado
                from venta v
                left join cliente c on c.id_cliente = v.cliente_id
                left join configfactura c2 on  c2.id_configfactura =v.configfactura_id
                where v.sucursal_id = $sucursal and v.fecha between '$fechaDesde' and '$fechaHasta' and v.accion_id = 1 and v.tipo_venta != 2";
            }else{
                $sql = "select 
                2 as tipoArchivo, 
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 15
                    when c.tipo_doc = 'CI' THEN 12
                    when c.tipo_doc = 'RUC' THEN 11
                    when c.tipo_doc = 'CEDULA EXTRANJERO' THEN 14
                    when c.tipo_doc = 'DIPLOMATICO' THEN 16
                    when c.tipo_doc = 'PASAPORTE' THEN 13
                    when c.tipo_doc = 'IDENTIFICACION TRIBUTARIA' THEN 17
                end as ruc,
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 'X'
                    else SUBSTRING_INDEX(c.dni,'-',1)
                end as ss,
                '' as nombre,
                109 as factura,
                date_format(v.fecha, '%d/%m/%Y') as fecha, -- pendiente
                v.timbrado2 as timbrado,
                v.comprobante2 as fact,
                ifnull(ROUND(((v.grabada102 + v.iva102)),'.'),0) as MontoGravado10,
                ifnull(ROUND(((v.grabada52 + v.iva52)),'.'),0) as MontoGravado5,
                v.excenta2 as exento,
                ifnull(ROUND(((v.total)),'.'),0) as total,
                CASE
                    when v.condicioncompra2 = 'Contado' THEN 1
                    when v.condicioncompra2 = 'Credito' then 2
                end as metodocompra,
                'N' as nro_operacion,
                'S' as inputaIVA,
                'N' as inputaIRE,
                'N' as inputaIRP,
				'N' as imputa,
                '' as NroComprobanteAsociado,
                '' as TimbradoComprobanteAsociado
                from venta v
                left join cliente c on c.id_cliente = v.cliente_id
                left join configfactura c2 on  c2.id_configfactura =v.configfactura_id
                where v.sucursal_id = $sucursal and v.fecha between '$fechaDesde' and '$fechaHasta' and v.accion_id = 1 and v.tipo_venta != 2";
            }
        }else if($monedaPrincipal == "₲"){
            if($monedaSeleccionada == "US$"){
                $sql = "select 
                2 as tipoArchivo, 
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 15
                    when c.tipo_doc = 'CI' THEN 12
                    when c.tipo_doc = 'RUC' THEN 11
                    when c.tipo_doc = 'CEDULA EXTRANJERO' THEN 14
                    when c.tipo_doc = 'DIPLOMATICO' THEN 16
                    when c.tipo_doc = 'PASAPORTE' THEN 13
                    when c.tipo_doc = 'IDENTIFICACION TRIBUTARIA' THEN 17
                end as ruc,
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 'X'
                    else SUBSTRING_INDEX(c.dni,'-',1)
                end as ss,
                '' as nombre,
                109 as factura,
                date_format(v.fecha, '%d/%m/%Y') as fecha, -- pendiente
                v.timbrado2 as timbrado,
                v.comprobante2 as fact,
                ifnull(ROUND(((v.grabada102 + v.iva102) / (select valor2 from tipomoneda where simbolo = '$monedaPrincipal' and sucursal_id = $sucursal)),'.'),0) as MontoGravado10,
                ifnull(ROUND(((v.grabada52 + v.iva52) / (select valor2 from tipomoneda where simbolo = '$monedaPrincipal' and sucursal_id = $sucursal)),'.'),0) as MontoGravado5,
                v.excenta2 as exento,
                ifnull(ROUND(((v.total) / (select valor2 from tipomoneda where simbolo = '$monedaPrincipal' and sucursal_id = $sucursal)),'.'),0) as total,
                CASE
                    when v.condicioncompra2 = 'Contado' THEN 1
                    when v.condicioncompra2 = 'Credito' then 2
                end as metodocompra,
                'N' as nro_operacion,
                'S' as inputaIVA,
                'N' as inputaIRE,
                'N' as inputaIRP,
				'N' as imputa,
                '' as NroComprobanteAsociado,
                '' as TimbradoComprobanteAsociado
                from venta v
                left join cliente c on c.id_cliente = v.cliente_id
                left join configfactura c2 on  c2.id_configfactura =v.configfactura_id
                where v.sucursal_id = $sucursal and v.fecha between '$fechaDesde' and '$fechaHasta' and v.accion_id = 1 and v.tipo_venta != 2";
            }else{
                $sql = "select 
                2 as tipoArchivo, 
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 15
                    when c.tipo_doc = 'CI' THEN 12
                    when c.tipo_doc = 'RUC' THEN 11
                    when c.tipo_doc = 'CEDULA EXTRANJERO' THEN 14
                    when c.tipo_doc = 'DIPLOMATICO' THEN 16
                    when c.tipo_doc = 'PASAPORTE' THEN 13
                    when c.tipo_doc = 'IDENTIFICACION TRIBUTARIA' THEN 17
                end as ruc,
                CASE
                    when c.tipo_doc = 'SIN NOMBRE' THEN 'X'
                    else SUBSTRING_INDEX(c.dni,'-',1)
                end as ss,
                '' as nombre,
                109 as factura,
                date_format(v.fecha, '%d/%m/%Y') as fecha, -- pendiente
                v.timbrado2 as timbrado,
                v.comprobante2 as fact,
                ifnull(ROUND(((v.grabada102 + v.iva102)),'.'),0) as MontoGravado10,
                ifnull(ROUND(((v.grabada52 + v.iva52)),'.'),0) as MontoGravado5,
                v.excenta2 as exento,
                ifnull(ROUND(((v.total)),'.'),0) as total,
                CASE
                    when v.condicioncompra2 = 'Contado' THEN 1
                    when v.condicioncompra2 = 'Credito' then 2
                end as metodocompra,
                'N' as nro_operacion,
                'S' as inputaIVA,
                'N' as inputaIRE,
                'N' as inputaIRP,
				'N' as imputa,
                '' as NroComprobanteAsociado,
                '' as TimbradoComprobanteAsociado
                from venta v
                left join cliente c on c.id_cliente = v.cliente_id
                left join configfactura c2 on  c2.id_configfactura =v.configfactura_id
                where v.sucursal_id = $sucursal and v.fecha between '$fechaDesde' and '$fechaHasta' and v.accion_id = 1 and v.tipo_venta != 2";
            }
        }

        $query = Executor::doit($sql);
        return Model::many($query[0],new ReporteData());
    }


}

?>