
<?php


$server   = "localhost:3306";
$username = "root";
$password = "asysodonto";
$database = "rconsult_ventas";
$mysqli = new mysqli($server, $username, $password, $database);

$cliente_id =  $_POST['id_cliente'];
$directorio_destino = $_SERVER['DOCUMENT_ROOT'] . "/sibaris/storage/";

//$directorio_destino = "../../documentos/";


// Obtener el nombre y la ubicación temporal de cada archivo subido

$contrato_cliente_file = $_FILES['contrato_cliente_']['name'];
$temp_contrato = $_FILES['contrato_cliente_']['tmp_name'];
$archivo_identificacion = $_FILES['formularioIdentificacionCliente_']['name'];
$temp_identificacion = $_FILES['formularioIdentificacionCliente_']['tmp_name'];

$archivo_constitucion = $_FILES['escrituraConstitucionSociedad_']['name'];
$temp_constitucion = $_FILES['escrituraConstitucionSociedad_']['tmp_name'];

$archivo_cedula_iden = $_FILES['copiaCedulaSocios_']['name'];
$temp_cedula_iden = $_FILES['copiaCedulaSocios_']['tmp_name'];

$archivo_cedula_tribu = $_FILES['copiaCedulaRUC_']['name'];
$temp_cedula_tribu = $_FILES['copiaCedulaRUC_']['tmp_name'];

$archivo_declaracion_iva = $_FILES['declaracionesIVA_']['name'];
$temp_declaracion_iva = $_FILES['declaracionesIVA_']['tmp_name'];

$archivo_balance_gen = $_FILES['balanceGeneralEstadoResultados_']['name'];
$temp_balance_gen = $_FILES['balanceGeneralEstadoResultados_']['tmp_name'];

$archivo_form_ire = $_FILES['formularioIREPresentado_']['name'];
$temp_form_ire = $_FILES['formularioIREPresentado_']['tmp_name'];

$archivo_factura_ser = $_FILES['ultimaFacturaServicioBasico_']['name'];
$temp_factura_ser = $_FILES['ultimaFacturaServicioBasico_']['tmp_name'];

$archivo_cert_cumpli = $_FILES['certificadoCumplimientoTributario_']['name'];
$temp_cert_cumpli = $_FILES['certificadoCumplimientoTributario_']['tmp_name'];

$archivo_decla_jur = $_FILES['declaracionJuradaOrigenFondos_']['name'];
$temp_decla_jur = $_FILES['declaracionJuradaOrigenFondos_']['tmp_name'];

$archivo_consulta_lista_ofac = $_FILES['consultaListaOFACONU_']['name'];
$temp_consulta_lista_ofac = $_FILES['consultaListaOFACONU_']['tmp_name'];

$archivo_consulta_lista_peps = $_FILES['consultaListaOFACPEPs_']['name'];
$temp_consulta_lista_peps = $_FILES['consultaListaOFACPEPs_']['tmp_name'];

$archivo_matriz_riesgo = $_FILES['matrizRiesgo_']['name'];
$temp_matriz_riesgo = $_FILES['matrizRiesgo_']['tmp_name'];

$archivo_informconf = $_FILES['informconf_']['name'];
$temp_informconf = $_FILES['informconf_']['tmp_name'];

$archivo_reg_ins_seprelad = $_FILES['registroInscripcionSeprelad_']['name'];
$temp_reg_ins_seprelad = $_FILES['registroInscripcionSeprelad_']['tmp_name'];

// Mover los archivos subidos al directorio de destino
move_uploaded_file($temp_contrato, $directorio_destino . $contrato_cliente_file);
move_uploaded_file($temp_identificacion, $directorio_destino . $archivo_identificacion);
move_uploaded_file($temp_constitucion, $directorio_destino . $archivo_constitucion);
move_uploaded_file($temp_cedula_iden, $directorio_destino . $archivo_cedula_iden);
move_uploaded_file($temp_cedula_tribu, $directorio_destino . $archivo_cedula_tribu);
move_uploaded_file($temp_declaracion_iva, $directorio_destino . $archivo_declaracion_iva);
move_uploaded_file($temp_balance_gen, $directorio_destino . $archivo_balance_gen);
move_uploaded_file($temp_form_ire, $directorio_destino . $archivo_form_ire);
move_uploaded_file($temp_factura_ser, $directorio_destino . $archivo_factura_ser);
move_uploaded_file($temp_cert_cumpli, $directorio_destino . $archivo_cert_cumpli);
move_uploaded_file($temp_decla_jur, $directorio_destino . $archivo_decla_jur);
move_uploaded_file($temp_consulta_lista_ofac, $directorio_destino . $archivo_consulta_lista_ofac);
move_uploaded_file($temp_consulta_lista_peps, $directorio_destino . $archivo_consulta_lista_peps);
move_uploaded_file($temp_matriz_riesgo, $directorio_destino . $archivo_matriz_riesgo);
move_uploaded_file($temp_informconf, $directorio_destino . $archivo_informconf);
move_uploaded_file($temp_reg_ins_seprelad, $directorio_destino . $archivo_reg_ins_seprelad);

// Realizar la inserción en la base de datos con los nombres de archivo correspondientes
$contrato_cliente = mysqli_real_escape_string($mysqli, trim($_POST['contrato_cliente']));
var_dump($contrato_cliente);

$form_identificacion = mysqli_real_escape_string($mysqli, trim($_POST['formularioIdentificacionCliente']));
$escri_constitucion = mysqli_real_escape_string($mysqli, trim($_POST['escrituraConstitucionSociedad']));
$cedula_iden = mysqli_real_escape_string($mysqli, trim($_POST['copiaCedulaSocios']));
$cedula_tribu = mysqli_real_escape_string($mysqli, trim($_POST['copiaCedulaRUC']));
$declaracion_iva = mysqli_real_escape_string($mysqli, trim($_POST['declaracionesIVA']));
$balance_gen = mysqli_real_escape_string($mysqli, trim($_POST['balanceGeneralEstadoResultados']));
$form_ire = mysqli_real_escape_string($mysqli, trim($_POST['formularioIREPresentado']));
$factura_ser = mysqli_real_escape_string($mysqli, trim($_POST['ultimaFacturaServicioBasico']));
$cert_cumpli = mysqli_real_escape_string($mysqli, trim($_POST['certificadoCumplimientoTributario']));
$decla_jur = mysqli_real_escape_string($mysqli, trim($_POST['declaracionJuradaOrigenFondos']));
$consulta_lista_ofac = mysqli_real_escape_string($mysqli, trim($_POST['consultaListaOFACONU']));
$consulta_lista_peps = mysqli_real_escape_string($mysqli, trim($_POST['consultaListaOFACPEPs']));
$matriz_riesgo = mysqli_real_escape_string($mysqli, trim($_POST['matrizRiesgo']));
$informconf = mysqli_real_escape_string($mysqli, trim($_POST['informconf']));
$reg_ins_seprelad = mysqli_real_escape_string($mysqli, trim($_POST['registroInscripcionSeprelad']));
$total_doc_presentar = mysqli_real_escape_string($mysqli, trim($_POST['totalDocumentosPresentar']));
$total_doc_presentado = mysqli_real_escape_string($mysqli, trim($_POST['totalDocumentosPresentados']));
$realizado_por = mysqli_real_escape_string($mysqli, trim($_POST['realizado']));
// 
if ($_GET['created'] == 'true') {
    $sql3 = "UPDATE `documentos_archivos` SET 
	        `contrato_cliente` = '$contrato_cliente_file', 
            `form_identificacion` = '$archivo_identificacion',
            `escri_constitucion` = '$archivo_constitucion',
            `cedula_iden` = '$archivo_cedula_iden',
            `cedula_tribu` = '$archivo_cedula_tribu',
            `declaracion_iva` = '$archivo_declaracion_iva',
            `balance_gen` = '$archivo_balance_gen',
            `form_ire` = '$archivo_form_ire',
            `factura_ser` = '$archivo_factura_ser',
            `cert_cumpli` = '$archivo_cert_cumpli',
            `decla_jur` = '$archivo_decla_jur',
            `consulta_lista_peps` = '$archivo_consulta_lista_peps',
            `consulta_list_ofac` = '$archivo_consulta_lista_ofac',
            `matriz_riesgo` = '$archivo_matriz_riesgo',
            `informconf` = '$archivo_informconf',
            `reg_ins_seprelad` = '$archivo_reg_ins_seprelad',
            `total_doc_presentar` = '$total_doc_presentar',
            `total_doc_presentado` = '$total_doc_presentado',
            `realizado_por` = '$realizado_por',
            `fecha` = CURRENT_TIMESTAMP
        WHERE `cliente_id` LIKE '$cliente_id';";
    echo "a " . $sql3;
} else {
    $sql3 = "INSERT INTO `documentos_archivos` (`id`, `cliente_id`, `form_identificacion`, `escri_constitucion`, `cedula_iden`, `cedula_tribu`, `declaracion_iva`, `balance_gen`, `form_ire`, `factura_ser`, `cert_cumpli`, `decla_jur`, `consulta_lista_peps`, `consulta_list_ofac`, `matriz_riesgo`, `informconf`, `reg_ins_seprelad`, `total_doc_presentar`, `total_doc_presentado`, `realizado_por`, `fecha`, `contrato_cliente` )
VALUES (NULL, '$cliente_id', '$archivo_identificacion', '$archivo_constitucion', '$archivo_cedula_iden', '$archivo_cedula_tribu', '$archivo_declaracion_iva', '$archivo_balance_gen', '$archivo_form_ire', '$archivo_factura_ser', '$archivo_cert_cumpli', '$archivo_decla_jur', '$archivo_consulta_lista_peps', '$archivo_consulta_lista_ofac', '$archivo_matriz_riesgo', '$archivo_informconf', '$archivo_reg_ins_seprelad', '$total_doc_presentar', '$total_doc_presentado', '$realizado_por', CURRENT_TIMESTAMP, $contrato_cliente)";
    echo "ab " . $sql3;
}

$contrato_cliente = mysqli_real_escape_string($mysqli, trim($_POST['contrato_cliente_ob']));
$form_identificacion = mysqli_real_escape_string($mysqli, trim($_POST['formularioIdentificacionCliente']));
$escri_constitucion = mysqli_real_escape_string($mysqli, trim($_POST['escrituraConstitucionSociedad']));
$cedula_iden = mysqli_real_escape_string($mysqli, trim($_POST['copiaCedulaSocios']));
$cedula_tribu = mysqli_real_escape_string($mysqli, trim($_POST['copiaCedulaRUC']));
$declaracion_iva = mysqli_real_escape_string($mysqli, trim($_POST['declaracionesIVA']));
$balance_gen = mysqli_real_escape_string($mysqli, trim($_POST['balanceGeneralEstadoResultados']));
$form_ire = mysqli_real_escape_string($mysqli, trim($_POST['formularioIREPresentado']));
$factura_ser = mysqli_real_escape_string($mysqli, trim($_POST['ultimaFacturaServicioBasico']));
$cert_cumpli = mysqli_real_escape_string($mysqli, trim($_POST['certificadoCumplimientoTributario']));
$decla_jur = mysqli_real_escape_string($mysqli, trim($_POST['declaracionJuradaOrigenFondos']));
$consulta_lista_ofac = mysqli_real_escape_string($mysqli, trim($_POST['consultaListaOFACONU']));
$consulta_lista_peps = mysqli_real_escape_string($mysqli, trim($_POST['consultaListaOFACPEPs']));
$matriz_riesgo = mysqli_real_escape_string($mysqli, trim($_POST['matrizRiesgo']));
$informconf = mysqli_real_escape_string($mysqli, trim($_POST['informconf']));
$reg_ins_seprelad = mysqli_real_escape_string($mysqli, trim($_POST['registroInscripcionSeprelad']));
$total_doc_presentar = mysqli_real_escape_string($mysqli, trim($_POST['totalDocumentosPresentar']));
$total_doc_presentado = mysqli_real_escape_string($mysqli, trim($_POST['totalDocumentosPresentados']));
$realizado_por = mysqli_real_escape_string($mysqli, trim($_POST['realizado']));

$fecha = $_POST['fecha'];




if ($_GET['created'] == 'true') {




    $sql = "UPDATE documentos_observacion SET 
	    contrato_cliente = '$contrato_cliente',
        form_identificacion = '$form_identificacion',
        escri_constitucion = '$escri_constitucion',
        cedula_iden = '$cedula_iden',
        cedula_tribu = '$cedula_tribu',
        declaracion_iva = '$declaracion_iva',
        balance_gen = '$balance_gen',
        form_ire = '$form_ire',
        factura_ser = '$factura_ser',
        cert_cumpli = '$cert_cumpli',
        decla_jur = '$decla_jur',
        consulta_list_ofac = '$consulta_lista_ofac',
        consulta_lista_peps = '$consulta_lista_peps',
        matriz_riesgo = '$matriz_riesgo',
        informconf = '$informconf',
        reg_ins_seprelad = '$reg_ins_seprelad',
        total_doc_presentar = '$total_doc_presentar',
        total_doc_presentado = '$total_doc_presentado',
        realizado_por = '$realizado_por',
        fecha = '$fecha'
        WHERE cliente_id LIKE '$cliente_id'";

    $sql2 = "UPDATE documentos_presento SET 
	    `contrato_cliente` = '$_POST[contrato_cliente]', 
        `form_identificacion` = '$_POST[ruc1]', 
        `escri_constitucion` = '$_POST[ruc2]', 
        `cedula_iden` = '$_POST[ruc3]', 
        `cedula_tribu` = '$_POST[ruc4]', 
        `declaracion_iva` = '$_POST[ruc5]', 
        `balance_gen` = '$_POST[ruc6]', 
        `form_ire` = '$_POST[ruc7]', 
        `factura_ser` = '$_POST[ruc8]', 
        `cert_cumpli` = '$_POST[ruc9]', 
        `decla_jur` = '$_POST[ruc10]', 
        `consulta_lista_peps` = '$_POST[ruc11]', 
        `consulta_list_ofac` = '$_POST[ruc12]', 
        `matriz_riesgo` = '$_POST[ruc13]', 
        `informconf` = '$_POST[ruc14]', 
        `reg_ins_seprelad` = '$_POST[ruc15]', 
        `total_doc_presentar` = '$_POST[ruc16]', 
        `total_doc_presentado` = '$_POST[ruc17]', 
        `realizado_por` = '$_POST[ruc18]' 
        WHERE `cliente_id` LIKE '$cliente_id';";
} else {

    $sql = "INSERT INTO documentos_observacion  (`id`, `cliente_id`, `form_identificacion`, `escri_constitucion`, `cedula_iden`, `cedula_tribu`, `declaracion_iva`, `balance_gen`, `form_ire`, `factura_ser`, `cert_cumpli`, `decla_jur`, `consulta_lista_peps`, `consulta_list_ofac`, `matriz_riesgo`, `informconf`, `reg_ins_seprelad`, `total_doc_presentar`, `total_doc_presentado`, `realizado_por`, `fecha`, `contrato_cliente`) " .
        "VALUES (NULL, '$cliente_id', '$form_identificacion', '$escri_constitucion', '$cedula_iden', '$cedula_tribu', '$declaracion_iva', '$balance_gen', '$form_ire', '$factura_ser', '$cert_cumpli', '$decla_jur', '$consulta_lista_ofac', '$consulta_lista_peps', '$matriz_riesgo', '$informconf', '$reg_ins_seprelad', '$total_doc_presentar', '$total_doc_presentado', '$realizado_por', '$fecha', '$contrato_cliente' )";
    $sql2 = "INSERT INTO documentos_presento (`id`, `cliente_id`, `form_identificacion`, `escri_constitucion`, `cedula_iden`, `cedula_tribu`, `declaracion_iva`, `balance_gen`, `form_ire`, `factura_ser`, `cert_cumpli`, `decla_jur`, `consulta_lista_peps`, `consulta_list_ofac`, `matriz_riesgo`, `informconf`, `reg_ins_seprelad`, `total_doc_presentar`, `total_doc_presentado`, `realizado_por`, `fecha`, `contrato_cliente`) " .
        "VALUES (NULL, '$cliente_id', '$_POST[ruc1]', '$_POST[ruc2]', '$_POST[ruc3]', '$_POST[ruc4]', '$_POST[ruc5]', '$_POST[ruc6]', '$_POST[ruc7]', '$_POST[ruc8]', '$_POST[ruc9]', '$_POST[ruc10]', '$_POST[ruc11]', '$_POST[ruc12]', '$_POST[ruc13]', '$_POST[ruc14]', '$_POST[ruc15]', '$_POST[ruc16]', '$_POST[ruc17]', '$_POST[ruc18]', '$fecha','$_POST[contrato_cliente]')";
}

//header('Location: ./index.php?view=cliente&id_sucursal=25&success=true');



$query = mysqli_query($mysqli, $sql)
    or die('Error : ' . mysqli_error($mysqli));
$query = mysqli_query($mysqli, $sql2)
    or die('Error : ' . mysqli_error($mysqli));
$query = mysqli_query($mysqli, $sql3)
    or die('Error : ' . mysqli_error($mysqli));
?>