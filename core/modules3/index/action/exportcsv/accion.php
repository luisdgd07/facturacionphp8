<?php
$con = new mysqli("localhost", "root", "", "syscombl");
$mysqli->set_charset("utf8");
$sql = "select * from venta";

$query = $con->query($sql);

if ($query) {
	while ($r  = $query->fetch_object()) {
		echo $r->id_venta . ",";
		echo $r->total . ",";
		echo (date_timestamp_get($r->fecha, "Y/m/d H:i:s"));
		echo $r->metodopago . ",";
		echo $r->cambio . ",";
		echo $r->id_venta . "\n";
	}
}

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename=export.csv;');
