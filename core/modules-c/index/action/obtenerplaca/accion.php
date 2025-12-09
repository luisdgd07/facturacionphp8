<?php
$result = PlacaData::listar($_GET['id_sucursal']);
echo json_encode($result);
