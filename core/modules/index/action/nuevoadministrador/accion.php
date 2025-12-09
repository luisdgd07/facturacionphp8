<?php
$c= UserData::getBDni($_POST["dni"]);
  if($c==null){
  $product = new UserData();
foreach ($_POST as $k => $v) {
  $product->$k = $v;
  # code...
}
$alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
			$imagen = new Upload($_FILES["imagen"]);
        	if ($imagen->uploaded) {
        		$url="storage/admin/";
            	$imagen->Process($url);

                $product->imagen = $imagen->file_dst_name;
                // $product->registrar_imagen();
    		}
        $product->password = sha1(md5($_POST["password"]));
$_SESSION["registro"]= 1;
$product->registrar_nuevo_administrador();
Core::alert("Registro de manera Éxistosa...!");
Core::redir("index.php?view=administrador");
}else{
Core::alert("Este administrador ya se encuentra Registrado...!");
Core::redir("index.php?view=administrador");
}
?>