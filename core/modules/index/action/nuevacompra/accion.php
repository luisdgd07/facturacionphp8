<?php $fech_actual=date("y-m-d H:i:s"); ?>
<?php
$product = new CompraData();
foreach ($_POST as $k => $v) {
  $product->$k = $v;
  # code...
}
$id_plato=$product->usuario_id = $_SESSION["admin_id"];
$_SESSION["registro"]= 1;
$prod=$product->registrar_compra();
	
Core::alert("Registro de manera Éxistosa...!");
Core::redir("index.php?view=compras");

?>