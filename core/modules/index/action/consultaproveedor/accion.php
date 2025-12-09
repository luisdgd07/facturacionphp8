<?php

	$consultadatos = $_POST['tipoMoneda'];

	echo json_encode(MonedaData::obtenerValorPorTipoMoneda($tipomomenda))

?>