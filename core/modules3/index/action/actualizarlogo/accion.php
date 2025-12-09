<?php
if (($_FILES["file"]["type"] == "image/pjpeg")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/png")
) {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], "logos/" . $_FILES['file']['name'])) {
        //more code here...
        $sucursal = new SuccursalData();
        $sucursal->actualizarlogo($_POST['id'], "logos/" . $_FILES['file']['name']);
        echo "logos/" . $_FILES['file']['name'];
    } else {
        echo 0;
    }
} else {
    echo 0;
}
