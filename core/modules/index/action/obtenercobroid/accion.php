<?php
$id = CobroCabecera::getultimoCobro();

echo json_encode($id->COBRO_ID + 1);
