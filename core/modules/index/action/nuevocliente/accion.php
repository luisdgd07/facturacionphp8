<?php
try {
    $c = ClienteData::getBDni($_POST["dni"], $_POST["id_sucursal"]);
    if ($c == null) {
        $product = new ClienteData();
        // PHP 8.4 compatible: Verificar que la propiedad existe antes de asignar
        foreach ($_POST as $k => $v) {
            if (property_exists($product, $k)) {
                $product->$k = $v;
            }
        }
        $alphabeth = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
        if (isset($_FILES["imagen"])) {
            $imagen = new Upload($_FILES["imagen"]);
            if ($imagen->uploaded) {
                $url = "storage/cliente/";
                $imagen->Process($url);
                $product->imagen = $imagen->file_dst_name;
                // $product->registrar_imagen();
            }
        }

        //$a= $_POST["sucursal"];
        $b = $_POST["nombre"];
        $product->nombre = $b;
        $product->dias_credito = 0;
        $product->tipo_operacion = 1;
        $_SESSION["registro"] = 1;
        $product->registrar_cliente();
        echo json_encode(['success' => true, 'message' => 'Cliente registrado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'El cliente con DNI ' . $_POST["dni"] . ' ya existe en esta sucursal']);
    }
} catch (Exception $e) {
    // Log del error para debugging
    error_log("Error en nuevocliente: " . $e->getMessage());

    // Respuesta de error para el cliente
    echo json_encode([
        'success' => false,
        'message' => 'Error interno del servidor: ' . $e->getMessage(),
        'error_code' => $e->getCode(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}
