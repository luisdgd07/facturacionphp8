<?php

	$facturadata = $_POST['confiFactura'];

	echo json_encode(ConfigFacturaData::obtenerdatosFactura($facturadata))

?>