<?php

$sucursalId = $_GET['id'];
echo json_encode(MonedaData::vermonedaid($sucursalId));
