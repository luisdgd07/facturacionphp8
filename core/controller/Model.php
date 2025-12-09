<?php


class Model
{

	public static function exists($modelname)
	{
		$fullpath = self::getFullpath($modelname);
		$found = false;
		if (file_exists($fullpath)) {
			$found = true;
		}
		return $found;
	}

	public static function getFullpath($modelname)
	{
		return "core/modules/" . Module::$module . "/model/" . $modelname . ".php";
	}

	/**
	 * Fetches multiple rows from a query result into an array of objects
	 * 
	 * @param mysqli_result $query The query result set
	 * @param string $aclass The class name to instantiate for each row
	 * @return array Array of objects of type $aclass
	 */
	public static function many(mysqli_result $query, string $aclass): array
	{
		$array = [];
		$i = 0;

		while ($row = $query->fetch_array(MYSQLI_BOTH)) {
			$array[$i] = new $aclass();
			$j = 1;

			foreach ($row as $key => $value) {
				if ($j % 2 === 0 && is_string($key)) {
					if (property_exists($array[$i], $key)) {
						$array[$i]->$key = $value;
					}
				}
				$j++;
			}
			$i++;
		}

		return $array;
	}

	/**
	 * Fetches a single row from a query result into an object
	 * 
	 * @param mysqli_result $query The query result set
	 * @param string $aclass The class name to instantiate
	 * @return object|null Returns an object of type $aclass or null if no rows
	 */
	public static function one(mysqli_result $query, string $aclass): ?object
	{
		if ($row = $query->fetch_assoc()) {
			$data = new $aclass();
			$refClass = new \ReflectionClass($aclass);

			foreach ($row as $key => $value) {
				if (!property_exists($data, $key)) {
					continue;
				}

				// Evitar avisos deprecados por conversión implícita de string con decimales a int
				if ($refClass->hasProperty($key)) {
					$prop = $refClass->getProperty($key);
					$type = $prop->getType();

					if ($type instanceof \ReflectionNamedType) {
						$typeName = $type->getName();

						// Si la propiedad es int y el valor es string numérico (incluyendo decimales),
						// hacemos la conversión explícita para evitar el warning deprecado.
						if ($typeName === 'int' && is_string($value) && is_numeric($value)) {
							$value = (int) round((float) $value);
						}

						// Si la propiedad es float y el valor viene como string numérico, lo casteamos.
						if ($typeName === 'float' && is_string($value) && is_numeric($value)) {
							$value = (float) $value;
						}
					}
				}

				$data->$key = $value;
			}
			return $data;
		}

		return null;
	}
}
