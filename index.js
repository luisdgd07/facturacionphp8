const express = require("express");
const cors = require("cors");
const fileUpload = require("express-fileupload");
const app = express();
app.use(cors());
const utf8 = require("utf8");
const xmlgen = require("facturacionelectronicapy-xmlgen").default;
const xmlsign = require("facturacionelectronicapy-xmlsign").default;
const setApi = require("facturacionelectronicapy-setapi").default;
const qrgen = require("facturacionelectronicapy-qrgen").default;
// const kude = require("facturacionelectronicapy-kude").default;
const bodyParser = require("body-parser");
const fs = require("fs");
const { json } = require("body-parser");
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(fileUpload());
app.get("/", async (req, res) => {
  res.send("facturacion");
});
function logMoment(msg, value = "") {
  var hoy = new Date();
  let now = hoy.toLocaleString("es");
  console.log("[" + now + "]" + " -> " + msg, value);
}

app.post("/enviar", async (req, res) => {
  try {
    let hoy = new Date();
    let dia = hoy.getDate();
    let mes = hoy.getMonth() + 1;

    if (dia < 10) {
      dia = "0" + dia;
    }
    if (mes < 10) {
      mes = "0" + mes;
    }
    let fecha = `${hoy.getFullYear()}-`;
    if (mes < 10) {
      fecha = fecha + `${mes}`;
    } else {
      fecha = fecha + `${mes}`;
    }
    if (dia < 9) {
      fecha = fecha + `-${dia}T00:00:00`;
    } else {
      fecha = fecha + `-${dia}T00:00:00`;
    }
    let codigoSeguridad = Math.round(Math.random() * 999999);
    let item = JSON.parse(req.body.items);
    let items = [];
    for (i = 0; i < item.length; i++) {
      items.push(JSON.parse(item[i]));
    }
    let tipo = {};
    if (req.body.tipo == "Contado") {
      tipo = {
        tipo: 1,
        entregas: [
          {
            tipo: 1,
            monto: req.body.total,
            moneda: req.body.moneda,
            cambio: req.body.cambio,
          },
        ],
      };
    } else {
      tipo = {
        tipo: 2,

        credito: {
          tipo: 2,
          plazo: "",
          cuotas: req.body.cuotas,
          montoEntrega: 0,
          infoCuotas: [
            {
              moneda: req.body.moneda,
              monto: req.body.total,
              vencimiento: req.body.vencimiento,
            },
          ],
        },
      };
    }

    let data1 = {
      version: 150,
      fechaFirmaDigital: "2022-07-5T00:00:00",
      ruc: "3997053-1",
      razonSocial:
        "DE generado en ambiente de prueba - sin valor comercial ni fiscal",
      nombreFantasia:
        "DE generado en ambiente de prueba - sin valor comercial ni fiscal",
      actividadesEconomicas: [
        {
          codigo: "62010",
          descripcion: "ACTIVIDADES DE PROGRAMACIÓN INFORMÁTICA",
        },
      ],
      timbradoNumero: "12559590",
      timbradoFecha: "2022-06-21T00:00:00",
      tipoContribuyente: 2,
      tipoRegimen: 8,
      establecimientos: [
        {
          codigo: "001",
          direccion: "Barrio Carolina",
          numeroCasa: 1937,
          complementoDireccion1: "11 DE SETIEMBRE 1937 CASI HUMAITA",
          complementoDireccion2: "11 DE SETIEMBRE 1937 CASI HUMAITA",
          departamento: 1,
          departamentoDescripcion: "CAPITAL",
          distrito: 1,
          distritoDescripcion: "ASUNCION (DISTRITO)",
          ciudad: 1,
          ciudadDescripcion: "ASUNCION (DISTRITO)",
          telefono: "1234567",
          email: "DIELOSI@GMAIL.COM",
          denominacion: "Sucursal 1",
        },
      ],
    };

    let data2 = {
      tipoDocumento: 1,
      establecimiento: req.body.establecimiento,
      codigoSeguridadAleatorio: codigoSeguridad,
      punto: req.body.punto,
      numero: req.body.factura,
      descripcion: "",
      observacion: "",
      fecha: fecha,
      tipoEmision: 1,
      tipoTransaccion: 1,
      tipoImpuesto: 1,
      moneda: req.body.moneda,
      condicionTipoCambio: 1,
      cambio: req.body.cambio,
      cliente: {
        contribuyente: true,
        ruc: "80007801-2",
        razonSocial: req.body.cliente,
        nombreFantasia: req.body.cliente,
        tipoOperacion: 1,
        direccion: req.body.dirCliente,
        numeroCasa: "0",
        departamento: req.body.departamentoCliente,
        departamentoDescripcion: "",
        distrito: req.body.distritoCliente,
        distritoDescripcion: "",
        ciudad: 4,
        ciudadDescripcion: "",
        pais: "PRY",
        paisDescripcion: "Paraguay",
        tipoContribuyente: 2,
        documentoTipo: 1,
        documentoNumero: "",
        telefono: "",
        celular: "",
        email: "",
        codigo: 123,
      },

      factura: {
        presencia: 1,
      },
      condicion: tipo,
      items: items,
    };
    let result = {};
    let response = "";

    let ahora =
      hoy.getDate() +
      "_" +
      (hoy.getMonth() + 1) +
      "_" +
      hoy.getFullYear() +
      "_" +
      hoy.getHours() +
      "_" +
      hoy.getMinutes() +
      "_" +
      hoy.getSeconds();
    await xmlgen
      .generateXMLDE(data1, data2)
      .then(async (xml) => {
        await xmlsign
          .signXML(xml, req.body.cert, req.body.pass)
          .then(async (xmlFirmado) => {
            await qrgen
              .generateQR(
                xmlFirmado,
                "1",
                "ABCD0000000000000000000000000000",
                req.body.env
              )
              .then(async (xmlqr) => {
                let qr = [];

                var xmlFormateado = xmlqr.replace(/(\r\n|\n|\r)/gm, "");
                let nombreArchivo = "";
                let Archivo = "";
                try {
                  nombreArchivo =
                    "xmls/" +
                    req.body.cliente +
                    "-Fecha=" +
                    req.body.fechaVenta +
                    "-envio=" +
                    ahora +
                    ".xml";
                  Archivo =
                    req.body.cliente +
                    "-Fecha=" +
                    req.body.fechaVenta +
                    "-envio=" +
                    ahora +
                    ".xml";
                  const data = fs.writeFileSync(nombreArchivo, xmlFormateado);
                } catch (e) {
                  console.log(e);
                }

                await setApi
                  .recibe(
                    "100",
                    xmlqr,
                    req.body.env,
                    req.body.cert,
                    req.body.pass
                  )
                  .then(async (xml) => {
                    result = {
                      file: Archivo,
                      response: xml,
                      qr: qr,
                    };
                    console.log(JSON.stringify(xml));
                  })
                  .catch((e) => {
                    response = e;
                    console.log(e);
                  });
              });
          });
      })
      .catch((error) => {
        console.log(error);
      });
    // res.send(req.body)

    console.log("------------------------------");
    console.log("------------------------------");
    res.send(result);
  } catch (e) {
    console.log(e);

    res.send("Ocurrio un error: ");
  }
});
app.post("/enviarlote", async (req, res) => {
  const items = JSON.parse(req.body.datos);

  try {
    let genXml = [];
    let allXml = [];
    let allFirmas = [];
    let allQr = [];
    let result = "";
    let hoy = new Date();
    let dia = hoy.getDate();
    let mes = hoy.getMonth() + 1;
    if (dia < 10) {
      dia = "0" + dia;
    }
    if (mes < 10) {
      mes = "0" + mes;
    }
    let fecha = `${hoy.getFullYear()}-`;
    if (mes < 10) {
      fecha = fecha + `${mes}`;
    } else {
      fecha = fecha + `${mes}`;
    }
    if (dia < 9) {
      fecha = fecha + `-${dia}T00:00:00`;
    } else {
      fecha = fecha + `-${dia}T00:00:00`;
    }
    for (const xmlgenerado of items) {
      let detalles = [];
      detalles.push(xmlgenerado.items);
      detalle = detalles[0];
      let codigoSeguridad = Math.round(Math.random() * 999999);

      if (xmlgenerado.tipo == "Contado") {
        tipo = {
          tipo: 1,
          entregas: [
            {
              tipo: 1,
              monto: xmlgenerado.total,
              moneda: xmlgenerado.moneda,
              cambio: xmlgenerado.cambio,
            },
          ],
        };
      } else {
        tipo = {
          tipo: 2,

          credito: {
            tipo: 2,
            plazo: "",
            cuotas: xmlgenerado.cuotas,
            montoEntrega: 0,
            infoCuotas: [
              {
                moneda: xmlgenerado.moneda,
                monto: xmlgenerado.total,
                vencimiento: xmlgenerado.vencimiento,
              },
            ],
          },
        };
      }
      let data1 = JSON.parse(req.body.data1);
      let data2 = {
        tipoDocumento: parseInt(req.body.tipo),
        establecimiento: xmlgenerado.establecimiento,
        codigoSeguridadAleatorio: codigoSeguridad,
        punto: xmlgenerado.punto,
        numero: xmlgenerado.factura,
        descripcion: req.body.descripcion,
        observacion: "",
        fecha: fecha,
        tipoEmision: 1,
        tipoTransaccion: 1,
        tipoImpuesto: 1,
        moneda: xmlgenerado.moneda,
        condicionTipoCambio: 1,
        cambio: xmlgenerado.cambio,

        cliente: {
          contribuyente: true,
          ruc: xmlgenerado.rucCliente,
          razonSocial: xmlgenerado.cliente,
          nombreFantasia: xmlgenerado.cliente,
          tipoOperacion: 1,
          direccion: xmlgenerado.dirCliente,
          numeroCasa: "0",
          departamento: xmlgenerado.departamentoCliente,
          departamentoDescripcion: "",
          distrito: xmlgenerado.distritoCliente,
          distritoDescripcion: "",
          ciudad: xmlgenerado.ciudadCliente,
          ciudadDescripcion: "",
          pais: "PRY",
          paisDescripcion: "Paraguay",
          tipoContribuyente: xmlgenerado.contriuyenteCliente,
          documentoTipo: xmlgenerado.docCliente,
          documentoNumero: "",
          telefono: "",
          celular: "",
          email: "",
          codigo: 111,
        },

        factura: {
          presencia: 1,
        },
        condicion: tipo,
        items: detalle,
      };
      console.log(xmlgenerado.docCliente);
      console.log(req.body.ventaremision);
      if (parseInt(req.body.tipo) == 7) {
        data2["detalle"] = "remision";
        let remision = xmlgenerado.remision;
        let transporte = xmlgenerado.transporte;
        data2["remision"] = remision;
        data2["detalleTransporte"] = transporte;
      } else if (parseInt(req.body.tipo) == 5) {
        data2["detalle"] = "nota de credito/debito";
        let notaCreditoDebito = xmlgenerado.notaCreditoDebito;
        data2["notaCreditoDebito"] = notaCreditoDebito;
        let documentoAsociado = xmlgenerado.documentoAsociado;
        data2["documentoAsociado"] = documentoAsociado;
      } else if (
        parseInt(req.body.tipo) == 1 &&
        req.body.ventaremision == "true"
      ) {
        data2["detalle"] = "Venta de remision";
        let documentoAsociado = xmlgenerado.documentoAsociado;
        data2["documentoAsociado"] = documentoAsociado;
        // let remision = xmlgenerado.remision;
        // data2["remision"] = remision;
      }
      console.log(data2);

      await xmlgen
        .generateXMLDE(data1, data2)
        .then((xml) => {
          genXml.push(xml);
        })
        .catch((error) => {
          console.log(error);
          res.send(error.message);
          return;
        });
    }
    console.log(req.body.env);
    Promise.all(genXml)
      .then(async (xmls) => {
        await xmls.map((xmlgenerados) => {
          const firmarXmls = xmlsign.signXML(
            xmlgenerados,
            req.body.cert,
            req.body.pass
          );
          allFirmas.push(firmarXmls);
        });
        console.log(req.body.qr);
        // ejecutamos las promesas de las firmas
        Promise.all(allFirmas)
          .then((xmlsFirmados) => {
            xmlsFirmados.map(function (xmlQrs) {
              const qrs = qrgen.generateQR(
                xmlQrs,
                req.body.id,
                req.body.qr,
                req.body.env
              );

              allQr.push(qrs);
            });

            Promise.all(allQr)
              .then((qrsgenerados) => {
                let xmlguardados = [];
                let hoy = new Date();
                let nombreArchivo = "";
                let ahora =
                  hoy.getDate() +
                  "_" +
                  (hoy.getMonth() + 1) +
                  "_" +
                  hoy.getFullYear() +
                  "_" +
                  hoy.getHours() +
                  "_" +
                  hoy.getMinutes() +
                  "_" +
                  hoy.getSeconds();
                let qrs = [];

                try {
                  qrsgenerados.map(async function (xmlQrs) {
                    var xmlFormateado = xmlQrs.replace(/(\r\n|\n|\r)/gm, "");
                    qrs.push(
                      xmlFormateado.substring(
                        xmlFormateado.indexOf("<dCarQR>") + 8,
                        xmlFormateado.indexOf("</dCarQR>")
                      )
                    );

                    nombreArchivo =
                      "xmls/" +
                      xmlFormateado.substring(
                        xmlFormateado.indexOf("<dNomRec>") + 9,
                        xmlFormateado.indexOf("</dNomRec>")
                      ) +
                      "-envio=" +
                      ahora +
                      ".xml";
                    xmlguardados.push(
                      xmlFormateado.substring(
                        xmlFormateado.indexOf("<dNomRec>") + 9,
                        xmlFormateado.indexOf("</dNomRec>")
                      ) +
                        "-Fecha=" +
                        req.body.fechaVenta +
                        "-envio=" +
                        ahora +
                        ".xml"
                    );
                    await fs.writeFileSync(nombreArchivo, xmlFormateado);
                  });
                } catch (e) {
                  console.log(e);
                }
                setApi
                  .recibeLote(
                    req.body.id,
                    qrsgenerados,
                    req.body.env,
                    req.body.cert,
                    req.body.pass
                  )
                  .then((resultadoSET) => {
                    console.log(resultadoSET);
                    const result = {
                      xml: xmlguardados,
                      result: JSON.stringify(resultadoSET),
                      kude: qrs,
                      fecha: fecha,
                      xmlsgenerados: qrsgenerados,
                    };

                    res.send(result);
                  })
                  .catch((error) => {
                    console.log("error 4", error);
                    res.send(error);
                  });
              })
              .catch((error) => {
                console.log("error 3", error);
                res.send("error al generar QR");
              });
          })
          .catch((error) => {
            console.log("error 2", error);
            res.send("error con el certificado, compruebe ubicacion y clave");
          });
      })
      .catch((error) => {
        console.log("error 1", error);
        res.send("error");
      });

    console.log("------------------------------");
    console.log("------------------------------");
  } catch (e) {
    console.log(e);

    res.send("Ocurrio un error: ");
  }
});
app.post("/consultaruc", async (req, res) => {
  try {
    let response = "";
    setApi
      .consultaRUC(
        "1",
        req.body.ruc,
        req.body.env,
        req.body.cert,
        req.body.pass
      )
      .then((xml) => {
        // response = JSON.stringify(xml);
        let logXml = JSON.stringify(xml);
        console.log(logXml);
        response = xml;
      });

    res.send(response);
  } catch (e) {
    console.log(e);

    res.send("Ocurrio un error: ");
  }
});
app.post("/consultalote", async (req, res) => {
  try {
    console.log("consulta lote");
    let response = "";
    setApi
      .consultaLote(
        "100",
        req.body.lote,
        // "2958491852928608",
        // "test",
        req.body.env,
        // "facturacionElectronica/3997053.pfx",
        // "./3997053.pfx",
        req.body.cert,
        // "Die1905982022"
        req.body.pass
      )
      .then((xml) => {
        response = JSON.stringify(xml);
        let logXml = JSON.stringify(xml);
        console.log(logXml);
        res.send(response);
      });
  } catch (e) {
    console.log(e);

    res.send("Ocurrio un error: ");
  }
});
app.post("/cancelar", async (req, res) => {
  console.log("cancelando");
  let params = JSON.parse(req.body.data1);
  await xmlgen
    .generateXMLEventoCancelacion(req.body.id, params, {
      cdc: req.body.datos,
      motivo: "Se informa de una disconformidad",
    })
    .then(async (xml) => {
      await xmlsign
        .signXMLEvento(xml, req.body.cert, req.body.pass)
        .then(async (xmlFirmado) => {
          await setApi
            .evento(
              req.body.id,
              xmlFirmado,
              req.body.env,
              req.body.cert,
              req.body.pass
            )
            .then(async (xml) => {
              res.send(xml);
              console.log(JSON.stringify(xml));
            })
            .catch((e) => {
              res.send(e);
              console.log(e);
            });
        });
    })
    .catch((error) => {
      console.log(error);
    });
});
app.post("/subircert", async (req, res) => {
  try {
    let EDFile = req.files.file;
    EDFile.mv(`./facturacionElectronica/certs/${EDFile.name}`, (err) => {
      if (err) return res.status(500).send({ message: err });
      return res
        .status(200)
        .send({ message: "File upload", file: `/certs/${EDFile.name}` });
    });
  } catch (e) {
    console.log(e);

    res.send("Ocurrio un error: ");
  }
});

app.get("/downloadkude/:file", function (req, res) {
  res.download("../facturacionElectronica/kude/" + req.params.file);
  // res.download("./kude/" + req.params.file);
});
app.get("/downloadxml/:file", function (req, res) {
  res.download("./facturacionElectronica/xmls/" + req.params.file);
  // res.download("./xml/" + req.params.file);
});
// app.listen(3000, "172.26.12.69", () => {
//   console.log("Servidor corriendo en puerto 3000");
// });
app.listen(3000, () => {
  console.log("Servidor corriendo en puerto 3000");
});
// app.listen(3000, "127.0.0.1", () => {
//   console.log("Servidor corriendo en puerto 4000");
// });
