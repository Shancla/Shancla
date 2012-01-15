<?php
// -------------------------------------------------------------------------------------------
// FUNCIONES DE SCRIPT
// -------------------------------------------------------------------------------------------

// VALIDACION DE DATOS DEL FORMULARIO
function leer_cookie() {
	if ($_COOKIE["latitud_longitud"]) {
		$localización = $_COOKIE["latitud_longitud"];
		preg_match("\(%1,%2\)",$localizacion,$grados);
		$latitud_longitud("latitud")=$grados[1];
		$latitud_longitud("longitud")=$grados[2];
		return $latitud_longitud;
	} else { 
		return false; 
	}
}

function vacio($cadena) {
	if ($cadena!="") { 
		for ($i=0; $i<strlen($cadena); $i++) {
			if ($cadena[i]!=" ") {
				return false;
			} 
		}
	}
	return true;
}

function validar($i_busqueda,$i_fecha) {
	$validado=true;
	$errorvalidacion="";
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
	if (!leer_cookie) {
		$validado=false;
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
		$query = "SELECT * FROM anuncios WHERE ";
		
		// Si Etiquetas está marcado añado etiquetas.  	
		if ($_POST["tag"]) {
			$columnas.="etiqueta,";
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
		$latitud_longitud=leer_cookie();
		
		
		
		//Crea cunsulta final 
		$columnas=rtrim($columnas,",");
		if ($columnas == "") { $columnas="etiquetas"; }
		$query.="MATCH ($columnas) AGAINST ('$cadena_busqueda') $condiciondefecha $condiciondelocalizacion";
	}
	
		//HACER CONSULTA (NO DESARROLLADO)
		
		
	// FIN DE BUSQUEDA
	
	$tabla=mysql_query($query);
	if (is_array($tabla)) {					
		while ($registro=mysql_fetch_array($tabla)) {
			echo $registro["Name"]." - ".$registro["District"]."<br>";
		}
	} else {
		echo "No hay resultados para esa búsqueda";
	}
?>