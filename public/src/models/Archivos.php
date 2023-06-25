<?php

class Archivo
{
	public static function GuardarImagenDePeticion($directorio, $nuevoNombre, $imageKey = 'imagen')
	{
		if (!is_dir($directorio))
			mkdir($directorio, 0777, true);

		$tmpName = $_FILES[$imageKey]["tmp_name"];
		$destino = $directorio . $nuevoNombre . '.jpg';

		return move_uploaded_file($tmpName, $destino);
	}

	public static function MoverImagen($origen, $destino, $archivo)
	{
		if (!is_dir($destino))
			mkdir($destino, 0777, true);

		return rename($origen . $archivo, $destino . $archivo);
	}
}