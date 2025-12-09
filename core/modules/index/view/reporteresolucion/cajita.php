<?php
        $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
?>
<div class="content-wrapper">
    <section class="content-header">
      <h1> <i class="fa  fa-bar-chart" style="color: orange;"></i> 
        REPORTE RESOLUCION 90
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            <div class="row">
            <div class="col-md-2">
              <select name="uso_id" id="cboTipoReporte" class="form-control">
                <option value="0">--  ELIGE TIPO DE REPORTE --</option>
                <option value="reporte_venta">REPORTE DE VENTA</option>
                <option value="reporte_compra">REPORTE DE COMPRA</option>
              </select>
            </div>
            <div class="col-md-2">
            <select required="" name="tipomoneda_id" id="tipomoneda_id" class="form-control">
              <input type="hidden" id="tipomoneda_id_hidden">
            </select>
            </div>
            <div class="col-md-3">
            <input type="date" name="txtFechaDesde" id="txtFechaDesde" class="form-control">
            </div>
            <div class="col-md-3">
            <input type="date" name="txtFechaHasta" id="txtFechaHasta" class="form-control">
            </div>
            <div class="col-md-2">
              <button class="btn btn-warning btn-block" onclick="buttonBuscarReporte()">Descargar</button>
            </div>

            </div>
              </div>
              <!-- TABLA DE REPORTE-->
            <div class="box-body hide">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th><center>Acción</center></th>
                </thead>
                <tbody>
                  <tr>
                  <td></td>
                  <td></td>
                  <td style="width:150px;"></td>
                  </tr>
                </tbody>
              </table>
              </div>
            </div>
          </div>
      </section>
              </div>
              <script src="res/dist/js/sweetalert2.all.min.js"></script>



<script>
  let numero_descargas = 0;

  //obtener la sucursal de la cuentra
  const url = window.location.search;//me trae la url con los parametros
  const urlParams = new URLSearchParams(url);

  const sucursal_cuenta = urlParams.get('id_sucursal');
  let ruc_sucursal = "";

  function obtenerFechaActual(){
    n =  new Date();
    y = n.getFullYear();
    m = n.getMonth() + 1;
    d = n.getDate();
    return  y+"-"+(m > 9?m:"0"+m)+"-"+(d>9?d:"0"+d)
  }

  //inicializar las fechas del reporte
  $("#txtFechaDesde").val(obtenerFechaActual());
  $("#txtFechaHasta").val(obtenerFechaActual());

  function buttonBuscarReporte(){

    //logica para monedas
    const txtHiddenTipoMonedaPrincipal = $("#tipomoneda_id_hidden").val();
    const txtMonedaSeleccionada = $("#tipomoneda_id").val();
    const cboTipoReporte = $("#cboTipoReporte").val();
    const txtFiltroFechaDesde = $("#txtFechaDesde").val();
    const txtFiltroFechaHasta = $("#txtFechaHasta").val();
    const filtros = {sucursal: sucursal_cuenta, reporte: cboTipoReporte, fechaDesde: txtFiltroFechaDesde, fechaHasta: txtFiltroFechaHasta, 
    monedaPrincipal: txtHiddenTipoMonedaPrincipal, monedaSeleccionada: txtMonedaSeleccionada};

    if(cboTipoReporte != 0){
      ajaxObtenerDatosReporte90(filtros);
    }else{
      alert("Completar los filtros requeridos.");
    }
    
  }

  function msgError(texto){
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: texto,
    });
  }

  function ajaxObtenerDatosReporte90(json){
    $.ajax({
      url : 'index.php?action=reporteResolucion90',
      type : 'POST',
      data : {
        txtFechaDesde: json.fechaDesde,
        txtFechaHasta: json.fechaHasta,
        sucursal: json.sucursal,
        tipoReporte: json.reporte,
        monedaPrincipal: json.monedaPrincipal,
        monedaSeleccionada: json.monedaSeleccionada,
        accion: 'reporte'
      },
      dataType : 'json',
      success : function(data) {
        exportarCsv(data, json.fechaDesde);
      },
      error : function(xhr, status) {
         alert("no se a podido descargar el reporte");
      }
    });
  }

  function cboListadoTipMonedas(json){
    $.ajax({
      url : 'index.php?action=consultamoneda',
      type : 'POST',
      data : {
        sucursal: sucursal_cuenta,
        accion: 'cboObtenerMonedas'
      },
      dataType : 'json',
      success : function(data) {
        let optionHTML = "";
        $("#tipomoneda_id_hidden").val(data[0].simbolo);
        if(data != null){
          for(let i=0;i<data.length;i++){
            optionHTML += "<option value="+data[i].simbolo+">"+data[i].nombre+"</option>";
          }
          $("#tipomoneda_id").html(optionHTML);
        }else{
          $("#tipomoneda_id").html("Sin monedas.");
        }
      },
      error : function(xhr, status) {
          console.log("Ha ocurrido un erro al solicitar las monedas.");
      }
    });
  }

  function ajaxObtenerRucSucursal(sucursalId){
    return new Promise((resolve, reject) => {
      $.ajax({
          type: 'POST',
          url: 'index.php?action=reporteResolucion90',
          data : {
            sucursal: sucursalId,
            accion: 'obtenerRuc'
          },
          dataType: "json",
          beforeSend: function (xhr) {
            
          },
          success: function (data, textStatus, jqXHR) {
              resolve(data);
          },
          error: function (jqXHR, textStatus, errorThrown) {
              reject('Error en la petición');
          }
      });
    })
  }

  cboListadoTipMonedas();

  ajaxObtenerRucSucursal(sucursal_cuenta).then(data=>{
    ruc_sucursal = data[0].ruc;
  });
  
  function exportarCsv(filtros, fechaInicio){
	  
	  
	
	 
     //var zip = new JSZip();
   //   zip.add("hello1.txt", "Hola Mundo");
    // var img = zip.folder("images");
    //  img.file("smile.gif", imgData, {base64: true});
    // csvContent = zip.generate();
     //location.href="data:application/zip;base64," + csvContent; 

	 
	  
	  
    let csvContent = "data:text/csv;charset=utf-8,";
	
	
	
	
	
	
    var encodedUri = encodeURI(csvContent);

    var numerador = "";
    numero_descargas++;
    var dateObj = new Date(fechaInicio.split('/').reverse().join('-'));

    var month = dateObj.getUTCMonth() + 1;
    var year = dateObj.getUTCFullYear();
    var mes_final = month > 9?month:"0"+month;

    if(numero_descargas < 10){
      numerador = "00"+numero_descargas;
    }else if(numero_descargas > 9){
      numerador = "0"+numero_descargas;
    }else if(numero_descargas > 99){
      numerador = numero_descargas;
    }



    let nombre_archivo  = "";

    if($("#cboTipoReporte").val() == "reporte_venta"){
      nombre_archivo = ruc_sucursal + "_"+"REG"+ "_" + mes_final + "" + year + "_IV" +numerador;
    }else if($("#cboTipoReporte").val() == "reporte_compra"){
      nombre_archivo = ruc_sucursal + "_"+"REG"+ "_" + mes_final + "" + year + "_IC" +numerador;
    }

    for(let i=0;i<filtros.length;i++){
      let array_for = Object.values(filtros[i]);
      let row = array_for.join(",")
      csvContent += row + "\r\n";
    }

    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", nombre_archivo);
    document.body.appendChild(link);
    
    link.click();
  }





</script>