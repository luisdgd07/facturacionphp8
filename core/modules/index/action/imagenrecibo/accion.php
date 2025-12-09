<?php
$product =  new ReciboData();
foreach ($_POST as $k => $v) {
	$product->$k = $v;
	# code...
}
$alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
			$imagen = new Upload($_FILES["imagen"]);
        	if ($imagen->uploaded) {
        		$url="storage/recio/";
            	$imagen->Process($url);

                $product->imagen = $imagen->file_dst_name;
    		}
 $b=$product->registrar();
$at = new VetaReciboData();
	$at->recibo_id = $b[1];
	$at->venta_id = $_POST["id_venta"];
	$at->si();
core::alert("se Importo de Con Exito..!");
print "<script>window.location='index.php?view=recibo&id_venta=$_POST[id_venta]';</script>";
// Core::redir("index.php?view=teamm&product_id=".$_POST["tid"]);

?>
