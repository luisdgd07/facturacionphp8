<?php
		for ($i = 0; $i < $_POST['cantidad']; $i++) {

			$op = new VentaData1();
			$op->n1 = $_POST["n1"];
			$op->n2 = $_POST["n2"];
			$op->n3 = $_POST["n3"];
			$op->n4 = $_POST["n4"];

			$op->registro();			 		

		}
		// print "<script>window.location='index.php?view=detalleventaproducto&id_venta=$s[1]';</script>";


?>
