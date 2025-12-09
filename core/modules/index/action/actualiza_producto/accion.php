<?php
$product = new ProductoData();
$product->nombre = $_POST['nombre'];
$product->categoria_id = $_POST['categoria_id'];
$product->marca_id = $_POST['marca_id'];
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == UPLOAD_ERR_OK) {
    $imagen_tmp = $_FILES["imagen"]["tmp_name"];
    $extension = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
    $nombre_imagen = uniqid() . "." . $extension;
    $url = "storage/producto/" . $nombre_imagen;
    if (move_uploaded_file($imagen_tmp, $url)) {
        $product->imagen = $nombre_imagen;
    }
} else {
    $product->imagen = '';
}
$product->impuesto = $_POST['impuesto'];

$product->descripcion = $_POST['descripcion'];
$product->presentacion = $_POST['presentacion'];
$product->estado = $_POST['estado'];
$product->precio_compra = 0;
$product->inventario_minimo = $_POST['inventario_minimo'];
$product->id_producto = $_POST['id_producto'];
$product->sucursal_id = $_POST['sucursal_id'];
$product->precio_venta = $_POST['precio_venta'];
$product->cliente_id = $_POST['cliente_id'];
$product->contrato_id = $_POST['contrato_id'];
$product->moneda = $_POST['moneda'];
$product->fecha_vencimiento = $_POST['fecha_vencimiento'];

$product->codigoNivelGeneral = $_POST['codigo_nivel_general'];
$product->codigoNivelEspecifico = $_POST['codigo_nivel_especifico'];
$product->codigoGtinProducto = $_POST['codigo_gtin_producto'];
$product->codigoNivelPaquete = $_POST['codigo_nivel_paquete'];
$product->partida_arancelaria = $_POST['partida_arancelaria'];
$product->ncm = $_POST['ncm'];
$product->id_grupo = $_POST['id_grupo'];


$res = $product->actualizar_Producto();

$insumos = new InsumosData();
$insumos->id = $_POST['id_producto'];
$insumos->delete();
// InsumosData::delete($_POST['id_producto']);
$cart =  json_decode($_POST['carrito']);
foreach ($cart as $c) {
    $insumos = new InsumosData();
    $insumos->producto_id
        = $_POST['id_producto'];
    $insumos->nombre = $c->producto;
    $insumos->insumo_id = $c->id;
    $insumos->cantidad = $c->cantidad;
    $insumos->precio = $c->precio;
    $insumos->total = $c->total;
    $insumos->id_sucursal = $_POST["id_sucursal"];
    $insumos->registrarnuevo();
}
echo 1;
