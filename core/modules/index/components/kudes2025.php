<script>
    <?php
    $sucursal = new SuccursalData();
    $sucursalDatos = $sucursal->VerId($_GET['id_sucursal']);
    ?>

    function genKude(items, object, placas) {
        Swal.fire({
            title: 'Generando kude',
            icon: 'info',
        })
        tipo = 0;
        let logo = 'logo.png';
             if (<?php echo $sucursalDatos->id_sucursal == 19 ? 'true' :  'false'; ?>) {
            logo = 'logo3.png';
            tipo = 3;
        } else if (<?php echo $sucursalDatos->id_sucursal == 20 ? 'true' :  'false'; ?>) {
            tipo = 2;
        } else if (<?php echo $sucursalDatos->id_sucursal == 18 ? 'true' :  'false'; ?>) {
            tipo = 1;
        } else if (<?php echo $sucursalDatos->id_sucursal == 17 ? 'true' :  'false'; ?>) {}



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
         let url = "http://18.208.224.72:3100/generarkude";
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
			 url = "http://18.208.224.72:3100/enviarcorreo";
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
                                window.open(`http://18.208.224.72:3100/kude/${dataResult.file}`)

                            })
                        } else {
                            console.log("error")
                            Swal.fire({
                                title: 'Error al enviar correo',
                                icon: 'error',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: `http://18.208.224.72:3100/kude/${dataResult.file}`,
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
                            window.open(`http://18.208.224.72:3100/kude/${dataResult.file}`)

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

        console.log('aaa',object)

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
        let url = "http://18.208.224.72:3100/generarkude";
        // let url = "http://localhost:3100/generarkude";
        if (placas) {
            const placasData = JSON.stringify(placas)
            data = {
                ...data,
                placas: placasData
            }
        }
        if (envioCorreo) {
            url = "http://18.208.224.72:3100/enviarcorreo";
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
                                    window.open(`http://18.208.224.72:3100/kude/${dataResult.file}`)
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
                            window.open(`http://18.208.224.72:3100/kude/${dataResult.file}`)

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