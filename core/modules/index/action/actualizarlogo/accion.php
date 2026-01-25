<?php
// Define the directory relative to the project root for file operations
// We are in core/modules/index/action/actualizarlogo/accion.php
// We need to go up 5 levels to reach project root: facturacionsincro/
$base_dir = dirname(__DIR__, 5);
$logo_folder = "logos";
$physical_target_dir = $base_dir . DIRECTORY_SEPARATOR . $logo_folder;

// Ensure the request has a file
if (isset($_FILES["file"])) {
    $allowed_types = ["image/pjpeg", "image/jpeg", "image/png"];

    if (in_array($_FILES["file"]["type"], $allowed_types)) {

        // Ensure the directory exists
        if (!file_exists($physical_target_dir)) {
            mkdir($physical_target_dir, 0777, true);
        }

        $filename = basename($_FILES["file"]["name"]);
        $physical_target_file = $physical_target_dir . DIRECTORY_SEPARATOR . $filename;

        // The path stored in DB and returned should be relative to web root
        $web_target_file = $logo_folder . "/" . $filename;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $physical_target_file)) {
            $sucursal = new SuccursalData();
            $sucursal->actualizarlogo($_POST['id'], $web_target_file);
            echo $web_target_file;
        } else {
            // Permission denied or other error
            error_log("Failed to move uploaded file to: " . $physical_target_file);
            echo 0;
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}
?>