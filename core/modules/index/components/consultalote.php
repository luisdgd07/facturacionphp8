<script>
    <?php
    $sucursal = new SuccursalData();
    $sucursalDatos = $sucursal->VerId($_GET['id_sucursal']);
    ?>

    function cancelar(cdc, id) {
        console.log(id)
        Swal.fire({
            title: 'Desea cancelar este CDC',
            showDenyButton: true,
            confirmButtonText: 'Cancelar CDC',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            if (result.isConfirmed) {
                datos2 = JSON.stringify(datos);
                Swal.fire({
                    title: 'Enviando cancelacion',
                    icon: 'info',
                })
                let data1 = {
                    version: 150,
                    fechaFirmaDigital: '<?php echo $sucursalDatos->fecha_firma ?>T00:00:00',
                    ruc: "<?php echo $sucursalDatos->ruc ?>",
                    razonSocial: "<?php echo $sucursalDatos->razon_social ?>",
                    nombreFantasia: "<?php echo $sucursalDatos->nombre_fantasia ?>",
                    actividadesEconomicas: [{
                        codigo: "<?php echo $sucursalDatos->codigo_act ?>",
                        descripcion: "<?php echo $sucursalDatos->actividad ?>",
                    }, ],
                    timbradoNumero: "<?php echo $sucursalDatos->timbrado ?>",
                    timbradoFecha: "<?php echo $sucursalDatos->fecha_tim ?>T00:00:00",
                    tipoContribuyente: 2,
                    tipoRegimen: 3,
                    establecimientos: [{
                        codigo: "00<?php echo $sucursalDatos->establecimiento ?>",
                        direccion: "<?php echo $sucursalDatos->direccion ?>",
                        numeroCasa: "<?php echo $sucursalDatos->numero_casa ?>",
                        complementoDireccion1: "<?php echo $sucursalDatos->com_dir ?>",
                        complementoDireccion2: "<?php echo $sucursalDatos->com_dir2 ?>",
                        departamento: <?php echo $sucursalDatos->cod_depart ?>,
                        departamentoDescripcion: "<?php echo $sucursalDatos->departamento_descripcion ?>",
                        distrito: <?php echo $sucursalDatos->distrito_id ?>,
                        distritoDescripcion: "<?php echo $sucursalDatos->distrito_descripcion ?>",
                        ciudad: <?php echo $sucursalDatos->id_ciudad ?>,
                        ciudadDescripcion: "<?php echo $sucursalDatos->ciudad_descripcion ?>",
                        telefono: "<?php echo $sucursalDatos->telefono ?>",
                        email: "<?php echo $sucursalDatos->email ?>",
                        denominacion: "<?php echo $sucursalDatos->denominacion ?>",
                    }, ],
                }
                let cert = '<?php echo $sucursalDatos->certificado_url ?>';
                console.log(cert);
                console.log(cdc)
                datosCert = JSON.stringify(data1)
                $.ajax({
                    url: "http://18.208.224.72:3000/cancelar",
                    //  url: "http://localhost:3000/cancelar",
                    type: "POST",
                    data: {

                        datos: cdc,
                        env: '<?php echo $sucursalDatos->entorno ?>',
                        cert: cert,
                        id: '<?php echo $sucursalDatos->id_envio; ?>',
                        pass: '<?php echo $sucursalDatos->clave ?>',
                        data1: datosCert,

                    },
                    success: function(dataResult) {
                        try {

                            if (dataResult['ns2:rRetEnviEventoDe']['ns2:gResProcEVe']['ns2:dEstRes'] == "Aprobado") {

                                Swal.fire({
                                    title: 'Aprobado',
                                    text: `el cdc ${cdc} ha sido cancelado`,
                                    icon: 'success',
                                    confirmButtonColor: '#ff0000',
                                    confirmButtonText: 'Recargar pagina'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload()
                                    }
                                })
                                $.ajax({
                                    url: 'index.php?action=cancelacioncdc&id=' + id,
                                    type: 'POST',
                                    cache: false,
                                    dataType: 'json',
                                    success: function(json) {


                                    },
                                    error: function(xhr, status) {
                                        console.log("Ha ocurrido un error.");
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: `${dataResult['ns2:rRetEnviEventoDe']['ns2:gResProcEVe']['ns2:dEstRes']} causa: ${dataResult['ns2:rRetEnviEventoDe']['ns2:gResProcEVe']['ns2:gResProc']['ns2:dMsgRes']}`,
                                    icon: 'error',
                                })
                            }

                        } catch (e) {}

                    },

                });
            } else if (result.isDenied) {}
        })

    }

    function consultaLote(lote, tipo = 'venta') {
        let cert = '<?php echo $sucursalDatos->certificado_url ?>';
        $.ajax({
            url: "http://18.208.224.72:3000/consultalote",
            // url: "http://localhost:3000/consultalote",

            type: "POST",
            data: {
                lote: lote,
                env: '<?php echo $sucursalDatos->entorno ?>',
                cert: cert,
                pass: '<?php echo $sucursalDatos->clave ?>',

            },

            success: function(dataResult) {

                try {
                    let dataEnviada = [];
                    let lotes = JSON.parse(dataResult);
                    let textoLote = "";
                    lotesenviados = lotes['ns2:rResEnviConsLoteDe']['ns2:gResProcLote'];
                    if (lotesenviados.length == undefined) {
                        console.log("aqui")
                        dataEnviada.push({
                            venta: ventas[0],
                            cdc: lotesenviados['ns2:id'],
                            estado: lotesenviados["ns2:dEstRes"],
                            xml: xmlsenviados[0],
                            kude: kude[0],

                        });
                        console.log("aqui2", dataEnviada);
                        textoLote += "Venta: " + ventas[0] + " " + lotesenviados["ns2:dEstRes"] + " causa:" + lotesenviados["ns2:gResProc"]["ns2:dMsgRes"];
                    } else {
                        console.log("aqui3");
                        for (let i = 0; i < lotesenviados.length; i++) {
                            console.log('ss ');
                            dataEnviada.push({
                                venta: ventas[i],
                                cdc: lotesenviados[i]['ns2:id'],
                                estado: lotesenviados[i]["ns2:dEstRes"],
                                xml: xmlsenviados[i],
                                kude: kude[i],

                            });
                            textoLote += "Venta: " + ventas[i] + " " + lotesenviados[i]["ns2:dEstRes"] + " " + lotesenviados[i]["ns2:gResProc"]["ns2:dMsgRes"] + "\n"
                        }
                    }

                    $.ajax({
                        url: 'index.php?action=agregarenviolote',
                        type: "POST",
                        cache: false,
                        data: {
                            data: dataEnviada,
                            fecha: fecha,
                            tipo
                        },
                        dataType: 'json',
                        success: function(json) {
                            console.log(json)



                        },
                        error: function(xhr, status) {
                            console.log("Ha ocurrido un error.", xhr);
                        }
                    });

                    Swal.fire({
                        title: 'Resultados',
                        text: textoLote,
                        icon: 'info',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Recargar pagina'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    })
                } catch (e) {

                    Swal.fire({
                        title: 'Error al recibir datos del lote',
                        text: `El lote ${$("#lote").val()} esta en procesamiento, espere en 30 segundos automaticamente se volvera a realizar la consulta`,
                        icon: 'error',
                        confirmButtonColor: '#ff0000',
                        confirmButtonText: 'Recargar pagina'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    })
                    setTimeout(function() {
                        consultaLote(lote, tipo);
                    }, 30000);
                }

            },

        });
    }
</script>