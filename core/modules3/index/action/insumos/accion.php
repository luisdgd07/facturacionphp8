<?php
$insumosData = InsumosData::find($_GET["id"]);
for ($i = 0; $i < count($insumosData); $i++) {
    $insumosData[$i]->codigo = ProductoData::getProducto2($insumosData[$i]->insumo_id)[0]->codigo;
}
echo json_encode($insumosData);
