<?php $conexion=mysql_connect ("localhost", "root", "123") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("world"); ?>

<!DOCTYPE html>

<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Shancla - buscador</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Miguel de Málaga">

	<!-- JAVASCRIPT y ESTILO PARA BÚSQUEDA AVANZADA DESPLEGABLE -->
	<script type="text/javascript">   
	
	function avanzada(divId,accion) {
	  	var ver = document.getElementById(divId);
		var mas = document.getElementById('mas');
		var menos = document.getElementById('menos');
		var busqueda= document.getElementById('buscar');
	 
		if (accion == 1) {  
			ver.style.display = 'inline';
			mas.style.display = 'none';
			menos.style.display = 'inline';
			buscar.value = 'Búsqueda avanzada'
			
		} else { 
			ver.style.display = 'none';
			mas.style.display = 'inline';
			menos.style.display = 'none';
			buscar.value = 'Buscar por etiquetas';
		}	  
	} 

	</script>
    
	<style type='text/css'>
		#avanzada {
			float:none;
			display:none;
		}
		#menos {
			float:none;
			display:none;
		}
		#mas {
			float:none;
			display:inline;
		}
	</style>
	<!-- Final de javascript y estilo para búsqueda avanzada desplegable -->
</head>
<body>
<!-- FORMULARIO -->
<form action='busqueda.php' method="post">	
	<input name='busqueda' type='text' size='100' value='' list='lista_de_etiquetas'>
	<datalist id='lista_de_etiquetas'>
	<?php /*
	$query="SELECT etiqueta FROM etiquetas ORDER BY etiqueta";
	$tabla=mysql_query($query);
	while($fila=mysql_fetch_assoc($tabla)) {
	echo "<option value='".$fila["etiqueta"]."'> /n"; 
	}
	*/
	?>
	</datalist>
		<div id='mas'><input type='button' value='&darr;' onclick='avanzada("avanzada",1)'></div>
		<div id='menos'><input type='button' value='&uarr;' onclick='avanzada("avanzada",2)'></div>	
		<input id='buscar' name='enviar' type='submit' value='buscar por etiquetas'><br>
		
		<div id='avanzada'>
			<!-- <input name='tag' type='checkbox'checked>Etiquetas -->
			<input name='titulo' type='checkbox' checked>T&iacute;tulo
			<input name='descripcion' type='checkbox'>Descripci&oacute;n
			A partir de:
			<input name='fecha' type='date' min="2012-01-01" max="<?php echo date("Y-m-d"); ?>" value='dd-mm-aaaa'>
			Cerca de:
			<input name='localizacion' type='text' disabled><br>
		</div>	
</form>

<?php
require("funciones_de_busqueda.php");

// SCRIPT DE BÚSQUEDA

if (!isset($_POST["enviar"])) {
	// NO SE HA HECHO NINGUNA BÚSQUEDA
	$buscar = false; 
	
} else {
	//SE HA HECHO UNA BÚSQUEDA
	$query = "";
	$validacion=validar($_POST["busqueda"],$_POST["fecha"]);
	$cadena_busqueda=preparar_cadena($_POST["busqueda"]);
	
	// Establecer el patrón de búsqueda
	
	// Búsqueda simple (por etiquetas); 
	
	
	if ($_POST["enviar"] == "buscar por etiquetas" && $validacion == true ) {
		
		$query = "SELECT * FROM etiquetas_y_anuncios JOIN etiquetas ON etiquetas_y_anuncios.id_etiqueta = etiquetas.id_etiqueta  WHERE MATCH (etiqueta) AGAINST ('$cadena_busqueda')"; 
	}
	
	// Busqueda avanzada 
	
	if ($_POST["enviar"] == "Búsqueda avanzada" && $validacion == true) {
	
		$columnas="";
		$condiciondefecha="";
		//Creo la query en cuatro pasos: 
		$query = "SELECT * FROM city WHERE ";
		
		/* PASO 1: Si Etiquetas está marcado añado etiquetas.  	
		if ($_POST["tag"]) {
			$columnas.="etiqueta,";
		}*/
		
		// PASO 2: Sí título está marcado añado titulo.	
		if ($_POST["titulo"]) {
			$columnas.="name,";
		}
		// PASO 3: Sí descripcion está marcado añado descripcion
		if ($_POST["descripcion"]) {
			$columnas.="District";
		}
		// PASO 4: Si hay una fecha límite de inicio añado la condición a where
		if ($_POST["fecha"] != "" && $_POST["fecha"] != "dd-mm-aaaa") {
			$fecha_inicial=date("Y-m-d h:i:s",strtotime($_POST["fecha"]));
			$condiciondefecha="AND fecha_publicacion >= '$fecha_inicial'";
		}
		$columnas=rtrim($columnas,",");
		if ($columnas == "") { $columnas="titulo"; }
		$query.="MATCH ($columnas) AGAINST ('$cadena_busqueda') $condiciondefecha";
	}
	
    echo "La consulta es: $query <br>";

	// FIN DE BUSQUEDA
	
	$tabla=mysql_query($query);
	if (is_array($tabla)) {					
		while ($registro=mysql_fetch_array($tabla)) {
			echo $registro["Name"]." - ".$registro["District"]."<br>";
		}
	} else {
		echo "No hay resultados para esa búsqueda";
	}
	
}


?>
</body>
</html>
