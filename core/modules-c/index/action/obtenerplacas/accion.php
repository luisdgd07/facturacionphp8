<?php
$placas = PlacaDetalleData::obtener($_GET['id']);
echo json_encode($placas);
