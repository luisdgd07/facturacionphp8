<?php 
	$escuela=new SucursalUusarioData();
	foreach ($_POST as $k => $v) {
		$escuela->$k = $v;
	}

  	$escuela->registro();
  	// Core::alert("Registrado");
  	Core::redir("index.php?view=administrador");
	
 ?>