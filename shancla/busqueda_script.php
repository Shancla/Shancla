<?php
// SOLO PARA FUNCIONAR EN MI BASE DE DATOS: RETIRAR //
$connection = mysql_connect('localhost', 'root', '') or die ('Imposible conectar al servidor Server!');
mysql_select_db('shancla_db') or die ('No ha sido posible seleccionar la BBDD');
// ----------------------------------------------------
// -------------------------------------------------------------------------------------------
// FUNCIONES DE SCRIPT
// -------------------------------------------------------------------------------------------

// VALIDACION DE DATOS DEL FORMULARIO
function leer_cookie() {
	if ($_COOKIE["latitud_longitud"]) {
		$localizacion = $_COOKIE["latitud_longitud"];
		$localizacion = trim($localizacion,"()");
		$grados = explode(",",$localizacion);
		$latitud_longitud["latitud"] = $grados[0];
		$latitud_longitud["longitud"] = $grados[1];
	} else { 
		$latitud_longitud = false;
	}
	return $latitud_longitud;
}

function vacio($cadena) {
	$esta_vacio = true;
	if ($cadena!="") { 
		for ($i=0; $i<strlen($cadena); $i++) {
			if ($cadena[$i]!=" ") {
				$esta_vacio = false;
			} 
		}
	}
	return $esta_vacio;
}

function validar($i_busqueda,$i_fecha) {
	$validado = true;
	$errorvalidacion = "";
	if (vacio($i_busqueda)) {
		$validado = false; 
		$errorvalidacion.= "Que introduzcas texto en el cajón de búsqueda facilitaría encontrar algo<br>";
	}
	if ($i_fecha != "" && $i_fecha != "dd-mm-aaaa") {
	
		if (!strtotime($i_fecha)) { 
			$validado = false;
			$errorvalidacion.= "Has introducido una fecha, pero no tiene el formato correcto<br>";
		}
	}
	if (!leer_cookie()) {
		$validado = false;
		$errorvalidacion.="Debes localizarte para mostrarte los anuncios cercanos a tu posición";
	}
	echo $errorvalidacion;
	return $validado;
}


//PREPARA LA CADENA DE BUSQUEDA (ELIMINA ETIQUETAS HTML, ESPACIOS AL INICIO O FINAL, ETC)

function preparar_cadena($cadena) {
	$cadenatratada = trim($cadena);
	$cadenatratada = strip_tags($cadenatratada);	
	return $cadenatratada;
}

// OBTIENE UN ARRAY CON LOS TAGS A PARTIR DE UNA CADENA DE TAGS SEPARADOS POR ESPACIOS

function obtener_tags($cadena) {
	$cadenatratada = preparar_cadena($cadena);
	$tagssintratar = explode(" ",$cadenatratada);
	$tagstratadas = array();
	$cola_query="";
	for ($i = 0; $i < count($tagssintratar); $i++) {
		if ($tagssintratar[$i]!="") {
			$tagstratadas[$i] = $tagssintratar[$i];
		}
	}
	return $tagstratadas;
}

// (NO DESARROLLADA) SUBRAYA LAS PALABRAS USADAS EN LA BÚSQUEDA

function subrayar($cadena, $tagstratadas) {

}

// -------------------------------------------------------------------------------------------
// SCRIPT DE BÚSQUEDA
// -------------------------------------------------------------------------------------------

	$query = "";
	$cadena_busqueda=preparar_cadena($_POST["busqueda"]);
	
	// Establecer el patrón de búsqueda
	
	
	if ( validar($_POST["busqueda"],$_POST["fecha"]) ) {
		
	
		$columnas="";
		$condiciondefecha="";
		$condiciondelocalizacion="";
		$query = "SELECT id_anuncio, lat, lng, id_marcador FROM anuncios WHERE ";
		
		// Si Etiquetas está marcado añado etiquetas.  	
		if ($_POST["tag"]) {
			$columnas.="etiquetas,";
		}
		
		// Sí título está marcado añado titulo.	
		if ($_POST["titulo"]) {
			$columnas.="titulo,";
		}
		// Sí descripcion está marcado añado descripcion
		if ($_POST["descripcion"]) {
			$columnas.="descripcion";
		}
		// Si hay una fecha límite de inicio añado la condición a where
		if ($_POST["fecha"] != "" && $_POST["fecha"] != "dd-mm-aaaa") {
			$fecha_inicial=date("Y-m-d h:i:s",strtotime($_POST["fecha"]));
			$condiciondefecha="AND fecha_publicacion >= '$fecha_inicial'";
		}
		// Limitar la búsqueda al área de localización
		$latitud_longitud = leer_cookie();
		$kilometros = 10;
		$condiciondelocalizacion = "AND ( 6371 * acos( cos( radians(".$latitud_longitud["latitud"].") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$latitud_longitud["longitud"].") ) + sin( radians(".$latitud_longitud["latitud"].") ) * sin( radians( lat ) ) )  < $kilometros )";	
		//Crea cunsulta final 
		$columnas=rtrim($columnas,",");
		if ($columnas == "") { 
			$columnas = "etiquetas"; 
		}
		$query.="MATCH ($columnas) AGAINST ('$cadena_busqueda') $condiciondefecha $condiciondelocalizacion";
	}
		//HACER CONSULTA
		// sólo para depuración
		 echo "query:".$query."<br>";
		// fin depuración	
		$tabla = mysql_query($query) or die ('Error en la consulta: $query. ' . mysql_error());
	
		while ($registros = mysql_fetch_assoc($tabla)) {
			echo $registros["id_anuncio"].",".$registros["lat"].",".$registros["lng"].",".$registros["id_marcador"]."\r\n";
		}
		
	// FIN DE BUSQUEDA
	
	
?>