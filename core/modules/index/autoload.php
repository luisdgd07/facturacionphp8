<?php
// autoload.php
// 10 octubre del 2014
// esta funcion elimina el hecho de estar agregando los modelos manualmente

function app_autoload($modelname)
{
	if (class_exists('Model') && Model::exists($modelname)) {
		include Model::getFullPath($modelname);
	}

	if (class_exists('Form') && Form::exists($modelname)) {
		include Form::getFullPath($modelname);
	}
}

// Registrar el autoload para PHP 7/8+
spl_autoload_register('app_autoload');
?>