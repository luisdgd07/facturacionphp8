<?php $fech_actual=date("y-m-d H:i:s"); ?>
<?php
$product = new ComprasData();
foreach ($_POST as $k => $v) {
  $product->$k = $v;
  # code...
}
$alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
      $imagen = new Upload($_FILES["imagen"]);
          if ($imagen->uploaded) {
            $url="storage/compra/";
              $imagen->Process($url);

                $product->imagen = $imagen->file_dst_name;
                // $product->registrar_imagen();
        }
$cantidad= $_POST["cantidad"];
$precio_compra= $_POST["precio_compra"];
$product->total = $cantidad*$precio_compra;
$product->usuario_id = $_SESSION["admin_id"];
$_SESSION["registro"]= 1;
$b=$product->registrar_compra();

$at = new DetalleCompra();
$at->compras_id = $b[1];
$at->compra_id = $_POST["compra_id"];
$at->si();

if($_POST["finalizado"]!=""){
$salida =  CompraData::getById($_POST["compra_id"]);
if(isset($_POST["finalizado"])) { $salida->finalizado=1; }else{ $salida->finalizado=0; }
$salida->actuaizarpago();

}
Core::alert("Registro de manera Éxistosa...!");
// Core::redir("index.php?view=compras");
Core::redir("index.php?view=micompra&id_compra=$_POST[compra_id]");

?>