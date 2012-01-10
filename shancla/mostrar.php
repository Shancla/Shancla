<?php
require("conexion.php");
error_reporting(0);

$id=$_POST['id'];

function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr); 
$xmlStr=str_replace('>','&gt;',$xmlStr); 
$xmlStr=str_replace('"','&quot;',$xmlStr); 
$xmlStr=str_replace("'",'&#39;',$xmlStr); 
$xmlStr=str_replace("&",'&amp;',$xmlStr); 
return $xmlStr; 
} 

// Opens a connection to a MySQL server
$connection=mysql_connect ($host, $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}
mysql_set_charset("utf8", $connection) or die ("error codificacion");
// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);

if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table
$query = "SELECT * FROM anuncios WHERE id=$id";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'id="' . $row['id'] . '" ';
  echo 'titulo="' . parseToXML($row['titulo']) . '" ';
  echo 'descripcion="' . parseToXML($row['descripcion']) . '" ';
  echo 'tipo="' . $row['tipo'] . '" ';
  echo 'precio="' . $row['precio'] . '" ';
  echo 'imagenes="' . parseToXML($row['imagenes']) . '" ';
  echo 'marcador="' . parseToXML($row['marcador']) . '" ';
  echo 'etiquetas="' . parseToXML($row['etiquetas']) . '" ';
  echo 'video="' . parseToXML($row['video']) . '" ';
  echo 'fecha="' . $row['fecha'] . '" ';
  echo 'email="' . parseToXML($row['email']) . '" ';
  echo 'telefono="' . $row['telefono'] . '" ';
  echo 'clave="' . parseToXML($row['clave']) . '" ';
  echo 'visitas="' . $row['visitas'] . '" ';
  echo 'direccion="' . parseToXML($row['direccion']) . '" ';
  echo 'lat="' . $row['lat'] . '" ';
  echo 'lng="' . $row['lng'] . '" ';
  echo '/>';
}

// End XML file
echo '</markers>';

?>