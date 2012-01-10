<?php
include("conexion.php");
echo "<script>\n";
$db=mysql_connect($host,$username,$password) or die ("Imposible conectar");
mysql_select_db($database,$db) or die("Imposible seleccionar la base de datos");
mysql_set_charset("utf8", $db) or die ("error codificacion");
$consulta=mysql_query("SELECT DISTINCT marcador FROM anuncios") or die ("error en la consulta");
if(mysql_num_rows($consulta)>0) {
	while ($row = mysql_fetch_array($consulta)) {
		echo "var icono$row[marcador] = new GIcon();\n";
		echo "icono$row[marcador].image = 'images/iconos/$row[marcador].png';\n";
		echo "icono$row[marcador].iconSize = new GSize(35, 40);\n";
		echo "icono$row[marcador].iconAnchor = new GPoint(10, 35);\n";
		echo "icono$row[marcador].shadow = 'images/iconos/shadow.png';\n";
		echo "icono$row[marcador].infoWindowAnchor = new GPoint(5, 1);\n";
		echo "\n";
	}
}
echo "var customIcons = [];\n";
$consulta=mysql_query("SELECT marcador FROM anuncios") or die ("error en la consulta");
if(mysql_num_rows($consulta)>0) {
	while ($row = mysql_fetch_array($consulta)) {
		echo "customIcons['$row[marcador]'] = icono$row[marcador];\n";
	}
}
echo "</script>";
?>
