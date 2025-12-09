<script>
    <?php
    $sucursal = new SuccursalData();
    $sucursalDatos = $sucursal->VerId($_GET['id_sucursal']);
    ?>
    const BASE_KUDE_URL = "http://18.208.224.72:3100";
    //const BASE_KUDE_URL = "http://localhost:3100";

    var datos = [];
    var ventas = [];
    var xmlsenviados = []
    var kudesData = []

    function genKude(items, object, placas) {
        Swal.fire({
            title: 'Generando kude',
            icon: 'info',
        })
        tipo = 0;
        let logo = 'logo.png';
        if (<?php echo $sucursalDatos->id_sucursal == 19 ? 'true' :  'false'; ?>) {
            logo = 'logo3.png';
            tipo = 4;
        } else if (<?php echo $sucursalDatos->id_sucursal == 20 ? 'true' :  'false'; ?>) {
            tipo = 2;
        } else if (<?php echo $sucursalDatos->id_sucursal == 18 ? 'true' :  'false'; ?>) {
            tipo = 1;
        } else if (<?php echo $sucursalDatos->id_sucursal == 17 ? 'true' :  'false'; ?>) {

        } else if (<?php echo $sucursalDatos->id_sucursal == 22 ? 'true' :  'false'; ?>) {
            tipo = 4;
        }



        let itemsVenta = JSON.stringify(items);
        console.log(object)
        let data = {
            sucursal: '<?php echo $sucursalDatos->razon_social ?>',
            timbrado: '<?php echo $sucursalDatos->timbrado ?>',
            actividad: `<?php echo $sucursalDatos->actividad ?>`,
            telefonoSucursal: '<?php echo $sucursalDatos->telefono ?>',
            direccion: '<?php echo $sucursalDatos->direccion ?>',
            distrito: '<?php echo $sucursalDatos->distrito_descripcion ?>',
            rucSuc: '<?php echo $sucursalDatos->ruc ?>',
            timbradoVi: '<?php echo $sucursalDatos->fecha_tim ?>',
            itemsVenta,
            tipo,
            logo
        }
        if (object.vipoVenta == 2) {
            data = {
                ...data,
                puntodir: "<?php echo $sucursalDatos->direccion ?>",
                puntociu: "<?php echo $sucursalDatos->ciudad_descripcion ?>",
                puntodep: "<?php echo $sucursalDatos->ciudad_descripcion ?>",
                flete: '<?php echo $sucursalDatos->razon_social ?>',
                transpor2: '<?php echo $sucursalDatos->razon_social ?>',
            }
        }
        let url = BASE_KUDE_URL + "/generarkude";
        //let url = "http://localhost:3100/generarkude";
        if (placas) {
            const placasData = JSON.stringify(placas)
            data = {
                ...data,
                placas: placasData
            }
        }
        if (object.envioCorreo) {
            //url = "http://18.208.224.72:3100/enviarcorreo";
            url = BASE_KUDE_URL + "/enviarcorreo";
            // url = "http://localhost:3100/enviarcorreo";
            data = {
                ...data,
                host: '<?php echo $sucursalDatos->host ?>',
                port: <?php echo $sucursalDatos->port ?>,
                secure: false,
                timbradoVi: '<?php echo $sucursalDatos->fecha_tim ?>',
                user: '<?php echo $sucursalDatos->email ?>',
                pass: '<?php echo $sucursalDatos->pass ?>',
                from: '<?php echo $sucursalDatos->email ?>',
                to: object.email,
            }
        }
        for (const prop in object) {
            if (object.hasOwnProperty(prop)) {
                data[prop] = object[prop];
            }
        }
        console.log(object)
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function(dataResult) {
                try {
                    if (envioCorreo) {
                        console.log('22', dataResult)
                        console.log('22', dataResult.success)
                        if (dataResult.success) {
                            Swal.fire({
                                title: 'Kude enviado',
                                text: `El correo se envio correctamente a ${object.email}`,
                                icon: 'success',
                                confirmButtonColor: '#00c853',
                                showDenyButton: true,
                                confirmButtonText: 'Descargar Kude'
                            }).then((result) => {
                                $.ajax({
                                    url: 'index.php?action=enviocorreo&id=' + object.id,
                                    type: 'POST',
                                    cache: false,
                                    dataType: 'json',
                                    success: function(json) {},
                                    error: function(xhr, status) {
                                        console.log("Ha ocurrido un error.");
                                    }
                                });
                                window.open(`${BASE_KUDE_URL}/kude/${dataResult.file}`)

                            })
                        } else {
                            console.log("error")
                            Swal.fire({
                                title: 'Error al enviar correo',
                                icon: 'error',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: `${BASE_KUDE_URL}/kude/${dataResult.file}`,
                                        type: 'GET',
                                        cache: false,
                                        dataType: 'json',
                                        success: function(json) {


                                        },
                                        error: function(xhr, status) {
                                            console.log("Ha ocurrido un error.");
                                        }
                                    });
                                }
                            })
                        }
                    } else {
                        console.log(dataResult)

                        if (dataResult.success) {
                            window.open(`${BASE_KUDE_URL}/kude/${dataResult.file}`)

                        } else {
                            Swal.fire({
                                title: 'Error al generar kude',
                                text: ``,
                                icon: 'error',
                                confirmButtonColor: '#ff0000',
                                confirmButtonText: 'Recargar pagina'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload()
                                }
                            })

                        }
                    }



                } catch (e) {
                    console.log(e)
                    Swal.fire({
                        title: 'Error al generar kude',
                        text: ``,
                        icon: 'error',
                        confirmButtonColor: '#ff0000',
                        confirmButtonText: 'Recargar pagina'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    })

                }

            },

        });
    }

    function generarKude(object, envioCorreo = false, placas) {

        console.log('aaa', object)

        Swal.fire({
            title: 'Generando kude',
            icon: 'info',
        })
        let logo = 'logo.png';
        let tipo = 0;
        if (<?php echo $sucursalDatos->id_sucursal == 19 ? 'true' :  'false'; ?>) {
            logo = 'logo3.png';
            tipo = 3;
        } else if (<?php echo $sucursalDatos->id_sucursal == 20 ? 'true' :  'false'; ?>) {
            tipo = 2;
        } else if (<?php echo $sucursalDatos->id_sucursal == 18 ? 'true' :  'false'; ?>) {
            tipo = 1;
        } else if (<?php echo $sucursalDatos->id_sucursal == 17 ? 'true' :  'false'; ?>) {

        } else if (<?php echo $sucursalDatos->id_sucursal == 22 ? 'true' :  'false'; ?>) {
            tipo = 4;
        }

        console.log(object)
        let data = {
            sucursal: '<?php echo $sucursalDatos->razon_social ?>',
            timbrado: '<?php echo $sucursalDatos->timbrado ?>',
            actividad: `<?php echo $sucursalDatos->actividad ?>`,
            telefonoSucursal: '<?php echo $sucursalDatos->telefono ?>',
            direccion: '<?php echo $sucursalDatos->direccion ?>',
            distrito: '<?php echo $sucursalDatos->distrito_descripcion ?>',
            rucSuc: '<?php echo $sucursalDatos->ruc ?>',
            timbradoVi: '<?php echo $sucursalDatos->fecha_tim ?>T00:00:00',
            tipo,
            itemsVenta: JSON.stringify(object.itemsVenta),
            logo
        }
        object.vipoVenta = parseInt(object.vipoVenta)
        if (object.vipoVenta == 2) {
            data = {
                ...data,
                puntodir: "<?php echo $sucursalDatos->direccion ?>",
                puntociu: "<?php echo $sucursalDatos->ciudad_descripcion ?>",
                puntodep: "<?php echo $sucursalDatos->ciudad_descripcion ?>",
                flete: '<?php echo $sucursalDatos->razon_social ?>',
                transpor2: '<?php echo $sucursalDatos->razon_social ?>',
            }
        }
        let url = BASE_KUDE_URL + "/generarkude";
        if (placas) {
            const placasData = JSON.stringify(placas)
            data = {
                ...data,
                placas: placasData
            }
        }
        if (envioCorreo) {
            url = BASE_KUDE_URL + "/enviarcorreo";
            data = {
                ...data,
                host: '<?php echo $sucursalDatos->host ?>',
                port: <?php echo $sucursalDatos->port ?>,
                secure: false,
                timbradoVi: '<?php echo $sucursalDatos->fecha_tim ?>',
                user: '<?php echo $sucursalDatos->email ?>',
                pass: '<?php echo $sucursalDatos->pass ?>',
                from: '<?php echo $sucursalDatos->email ?>',
                to: object.email,
            }
        }
        for (const prop in object) {
            if (object.hasOwnProperty(prop)) {
                data[prop] = object[prop];
            }
        }
        console.log(object)
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function(dataResult) {
                try {
                    if (envioCorreo) {
                        console.log('22', dataResult)
                        console.log('22', dataResult.success)
                        if (dataResult.success) {
                            $.ajax({
                                url: 'index.php?action=enviocorreo&id=' + object.id,
                                type: 'POST',
                                cache: false,
                                dataType: 'json',
                                success: function(json) {},
                                error: function(xhr, status) {
                                    console.log("Ha ocurrido un error.");
                                }
                            });

                            Swal.fire({
                                title: 'Kude enviado',
                                text: `El correo se envio correctamente a ${object.email}`,
                                icon: 'success',
                                confirmButtonColor: '#00c853',
                                showDenyButton: true,
                                confirmButtonText: 'Descargar Kude',
                                denyButtonText: 'Cerrar', // Texto para el botón Deny
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Si el usuario presiona "Descargar Kude"
                                    window.open(`${BASE_KUDE_URL}/kude/${dataResult.file}`)
                                } else if (result.isDenied) {
                                    // Si el usuario presiona "Cerrar" simplemente se cierra el modal
                                    Swal.close();
                                }
                            });

                        } else {
                            console.log("error")
                            Swal.fire({
                                title: 'Error al enviar correo',
                                icon: 'error',
                            }).then((result) => {

                            })
                        }
                    } else {
                        console.log(dataResult)

                        if (dataResult.success) {
                            window.open(`${BASE_KUDE_URL}/kude/${dataResult.file}`)

                        } else {
                            Swal.fire({
                                title: 'Error al generar kude',
                                text: ``,
                                icon: 'error',
                                confirmButtonColor: '#ff0000',
                                confirmButtonText: 'Recargar pagina'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload()
                                }
                            })

                        }
                    }



                } catch (e) {
                    console.log(e)
                    Swal.fire({
                        title: 'Error al generar kude',
                        text: ``,
                        icon: 'error',
                        confirmButtonColor: '#ff0000',
                        confirmButtonText: 'Recargar pagina'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    })

                }

            },

        });
    }



    function agregarLote(json, venta, kude) {
        console.log(json, venta)
        if (datos.some(item => item.id === json.id)) {

            let newVentas = ventas.filter((item) => item !== venta);
            ventas = newVentas;
            console.log(ventas);

            datos.splice(datos.findIndex(findByKey("id", json.id)), 1);

        } else if (datos.length == 10) {
            $("#" + venta).prop('checked', false);

            Swal.fire({
                title: "El limite de lotes es 10",
                icon: 'danger',
                confirmButtonText: 'Aceptar'
            });
        } else {
            ventas.push(venta);
            datos.push(json);
            kudesData.push(kude)
            console.log('j', json)
        }

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
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#aaa',
                        confirmButtonText: 'Enviar Kude',
                        cancelButtonText: 'Recargar página'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Acción para "Enviar Kude"
                            for (let index = 0; index < dataEnviada.length; index++) {
                                if (dataEnviada[index].estado == 'Aprobado') {
                                    kudesData[index].cdc = dataEnviada[index].cdc
                                    kudesData[index].kudeQr = dataEnviada[index].kude
                                    generarKude(kudesData[index], true)
                                }

                            }
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // Acción para "Recargar página"
                            location.reload();
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

    function generarTicket(object, envioCorreo = false, placas) {

        console.log('aaa', object)

        Swal.fire({
            title: 'Generando kude',
            icon: 'info',
        })
        let logo = 'logo.png';
        let tipo = 0;
        if (<?php echo $sucursalDatos->id_sucursal == 19 ? 'true' :  'false'; ?>) {
            logo = 'logo3.png';
            tipo = 3;
        } else if (<?php echo $sucursalDatos->id_sucursal == 20 ? 'true' :  'false'; ?>) {
            tipo = 2;
        } else if (<?php echo $sucursalDatos->id_sucursal == 18 ? 'true' :  'false'; ?>) {
            tipo = 1;
        } else if (<?php echo $sucursalDatos->id_sucursal == 17 ? 'true' :  'false'; ?>) {

        }

        console.log(object)
        let data = {
            sucursal: '<?php echo $sucursalDatos->razon_social ?>',
            timbrado: '<?php echo $sucursalDatos->timbrado ?>',
            actividad: `<?php echo $sucursalDatos->actividad ?>`,
            telefonoSucursal: '<?php echo $sucursalDatos->telefono ?>',
            direccion: '<?php echo $sucursalDatos->direccion ?>',
            distrito: '<?php echo $sucursalDatos->distrito_descripcion ?>',
            rucSuc: '<?php echo $sucursalDatos->ruc ?>',
            timbradoVi: '<?php echo $sucursalDatos->fecha_tim ?>T00:00:00',
            tipo,
            itemsVenta: JSON.stringify(object.itemsVenta),
            logo
        }
        object.vipoVenta = parseInt(object.vipoVenta)
        if (object.vipoVenta == 2) {
            data = {
                ...data,
                puntodir: "<?php echo $sucursalDatos->direccion ?>",
                puntociu: "<?php echo $sucursalDatos->ciudad_descripcion ?>",
                puntodep: "<?php echo $sucursalDatos->ciudad_descripcion ?>",
                flete: '<?php echo $sucursalDatos->razon_social ?>',
                transpor2: '<?php echo $sucursalDatos->razon_social ?>',
            }
        }
        let url = BASE_KUDE_URL + "/generar/ticket";
        // let url = "http://localhost:3100/generar/ticket";
        if (placas) {
            const placasData = JSON.stringify(placas)
            data = {
                ...data,
                placas: placasData
            }
        }
        if (envioCorreo) {
            url = BASE_KUDE_URL + "/enviarcorreo";
            // url = "http://localhost:3100/enviarcorreo";
            data = {
                ...data,
                host: '<?php echo $sucursalDatos->host ?>',
                port: <?php echo $sucursalDatos->port ?>,
                secure: false,
                timbradoVi: '<?php echo $sucursalDatos->fecha_tim ?>',
                user: '<?php echo $sucursalDatos->email ?>',
                pass: '<?php echo $sucursalDatos->pass ?>',
                from: '<?php echo $sucursalDatos->email ?>',
                to: object.email,
            }
        }
        for (const prop in object) {
            if (object.hasOwnProperty(prop)) {
                data[prop] = object[prop];
            }
        }
        console.log(object)
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function(dataResult) {
                try {
                    if (envioCorreo) {
                        console.log('22', dataResult)
                        console.log('22', dataResult.success)
                        if (dataResult.success) {
                            $.ajax({
                                url: 'index.php?action=enviocorreo&id=' + object.id,
                                type: 'POST',
                                cache: false,
                                dataType: 'json',
                                success: function(json) {},
                                error: function(xhr, status) {
                                    console.log("Ha ocurrido un error.");
                                }
                            });

                            Swal.fire({
                                title: 'Kude enviado',
                                text: `El correo se envio correctamente a ${object.email}`,
                                icon: 'success',
                                confirmButtonColor: '#00c853',
                                showDenyButton: true,
                                confirmButtonText: 'Descargar Kude',
                                denyButtonText: 'Cerrar', // Texto para el botón Deny
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Si el usuario presiona "Descargar Kude"
                                    window.open(`${BASE_KUDE_URL}/kude/${dataResult.file}`)
                                } else if (result.isDenied) {
                                    // Si el usuario presiona "Cerrar" simplemente se cierra el modal
                                    Swal.close();
                                }
                            });

                        } else {
                            console.log("error")
                            Swal.fire({
                                title: 'Error al enviar correo',
                                icon: 'error',
                            }).then((result) => {

                            })
                        }
                    } else {
                        console.log(dataResult)

                        if (dataResult.success) {
                            window.open(`${BASE_KUDE_URL}/kude/${dataResult.file}`)

                        } else {
                            Swal.fire({
                                title: 'Error al generar kude',
                                text: ``,
                                icon: 'error',
                                confirmButtonColor: '#ff0000',
                                confirmButtonText: 'Recargar pagina'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload()
                                }
                            })

                        }
                    }



                } catch (e) {
                    console.log(e)
                    Swal.fire({
                        title: 'Error al generar kude',
                        text: ``,
                        icon: 'error',
                        confirmButtonColor: '#ff0000',
                        confirmButtonText: 'Recargar pagina'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    })

                }

            },

        });
    }
</script>