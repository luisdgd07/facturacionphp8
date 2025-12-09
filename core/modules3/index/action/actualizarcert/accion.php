<?php
try {
    $sucursal = new SuccursalData();
    $sucursal->actualizarcert($_POST['id'], $_POST['cert']);
    echo 1;
} catch (Exception $error) {
    echo 0;
}
