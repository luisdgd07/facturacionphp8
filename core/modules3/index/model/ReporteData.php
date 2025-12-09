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
                    when c.tipo_doc = 'RUC' THEN 11
                    when c.tipo_doc = 'SIN NOMBRE' THEN 15
                    when c.tipo_doc = 'CI' THEN 12
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
				
				
				CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.total10 + v.iva10) * (v.cambio2)),'.'),0) 
				else
				ifnull(ROUND(((v.total10 + v.iva10) * (1)),'.'),0) 
			    end as  MontoGravado10,
				
				CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.total5 + v.iva5) * (v.cambio2)),'.'),0) 
				else
				ifnull(ROUND(((v.total5 + v.iva5) * (1)),'.'),0) 
			    end as  MontoGravado5,
				
                CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.exenta) * (v.cambio2)),'.'),0) 
				else
				ifnull(ROUND(((v.exenta) * (1)),'.'),0) 
			    end as  exento,
				
				
				 CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.total) * (v.cambio2)),'.'),0) 
				else
				ifnull(ROUND(((v.total) * (1)),'.'),0) 
			    end as  total,
				
               
               
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
                ifnull(ROUND(((v.total10 + v.iva10) / (v.cambio2)),'.'),0) as MontoGravado10,
                ifnull(ROUND(((v.total5 + v.iva5) / (v.cambio2)),'.'),0) as MontoGravado5,
                v.exenta as exento,
                ifnull(ROUND(((v.total) / (v.cambio2)),'.'),0) as total,
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
				
				CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.total10 + v.iva10) * (1)),'.'),0) 
				else
				ifnull(ROUND(((v.total10 + v.iva10) * (v.cambio2)),'.'),0) 
			    end as  MontoGravado10,
				
				CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.total5 + v.iva5) * (1)),'.'),0) 
				else
				ifnull(ROUND(((v.total5 + v.iva5) * (v.cambio2)),'.'),0) 
			    end as  MontoGravado5,
				
                CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.exenta) * (1)),'.'),0) 
				else
				ifnull(ROUND(((v.exenta) * (v.cambio2)),'.'),0) 
			    end as  exento,
				
				
				 CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.total) * (1)),'.'),0) 
				else
				ifnull(ROUND(((v.total) * (v.cambio2)),'.'),0) 
			    end as  total,
				
				
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
				
				
				
				CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.grabada102 + v.iva102) * (v.cambio2)),'.'),0) 
				else
				ifnull(ROUND(((v.grabada102 + v.iva102) * (1)),'.'),0) 
			    end as  MontoGravado10,
				
				CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.grabada52 + v.iva52) * (v.cambio2)),'.'),0) 
				else
				ifnull(ROUND(((v.grabada52 + v.iva52) * (1)),'.'),0) 
			    end as  MontoGravado5,
				
                CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.excenta2) * (v.cambio2)),'.'),0) 
				else
				ifnull(ROUND(((v.excenta2) * (1)),'.'),0) 
			    end as  exento,
				
				
				 CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.total) * (v.cambio2)),'.'),0) 
				else
				ifnull(ROUND(((v.total) * (1)),'.'),0) 
			    end as  total,
				
				
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
                ifnull(ROUND(((v.grabada102 + v.iva102) / (v.cambio2)),'.'),0) as MontoGravado10,
                ifnull(ROUND(((v.grabada52 + v.iva52) / (v.cambio2)),'.'),0) as MontoGravado5,
                v.excenta2 as exento,
                ifnull(ROUND(((v.total) / (v.cambio2)),'.'),0) as total,
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
				
				
				CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.grabada102 + v.iva102) * (1)),'.'),0) 
				else
				ifnull(ROUND(((v.grabada102 + v.iva102) * (v.cambio2)),'.'),0) 
			    end as  MontoGravado10,
				
				CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.grabada52 + v.iva52) * (1)),'.'),0) 
				else
				ifnull(ROUND(((v.grabada52 + v.iva52) * (v.cambio2)),'.'),0) 
			    end as  MontoGravado5,
				
                CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.excenta2) * (1)),'.'),0) 
				else
				ifnull(ROUND(((v.excenta2) * (v.cambio2)),'.'),0) 
			    end as  exento,
				
				
				 CASE
				when v.cambio = 1 THEN
                ifnull(ROUND(((v.total) * (1)),'.'),0) 
				else
				ifnull(ROUND(((v.total) * (v.cambio2)),'.'),0) 
			    end as  total,
				
				
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