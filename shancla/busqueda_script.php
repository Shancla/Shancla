<?php
//  VALIDACION DE DATOS DEL FORMULARIO
//malo
function validar($i_busqueda,$i_fecha) {
	$validado=true;
	$errorvalidacion="";
	if ($i_busqueda == "") {
		$validado = false; 
		$errorvalidacion.= "Que introduzcas texto en el cajón de búsqueda facilitaría encontrar algo ;)<br>";
	}
	if ($i_fecha != "" && $i_fecha != "dd-mm-aaaa") {
	
		if (!strtotime($i_fecha)) { 
			$validado = false;
			$errorvalidacion.= "Has introducido una fecha, pero no es el formato correcto<br>";
		}
	}
	echo $errorvalidacion;
	return $validado;
}



//PREPARA LA CADENA DE BUSQUEDA (ELIMINA ETIQUETAS HTML, ESPACIOS DOBLES, ETC)
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

function subrayar($cadena, $tagstratadas) {

}

?>