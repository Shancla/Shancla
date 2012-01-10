<?php
// Guardar los datos recibidos en variables:
$nombre = $_POST['nombre'];
$mail = $_POST['mail'];
$telefono = $_POST['telefono'];
$id = $_POST['id'];
$mensaje = $_POST['mensaje'];

// Recoger E-mail del anunciante según el id del anuncio
require("conexion.php");
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
	$query = "SELECT mail FROM anuncios WHERE id=$id";
	$result = mysql_query($query);
	if (!$result) {
	  die('Invalid query: ' . mysql_error());
	}
	while ($row = @mysql_fetch_assoc($result)){
		$dest=$row['mail'];
	}
 
// Estas son cabeceras que se usan para evitar que el correo llegue a SPAM:
$headers = "From: $nombre $email\r\n";
$headers .= "X-Mailer: PHP5\n";
$headers .= 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Aqui definimos el asunto y armamos el cuerpo del mensaje
$asunto = "Contacto";
$cuerpo = "Nombre: ".$nombre."<br>";
$cuerpo .= "Email: ".$mail."<br>";
$cuerpo .= "Telefono: ".$telefono."<br>";
$cuerpo .= "Mensaje: ".$mensaje;
 
// Esta es una pequena validación, que solo envie el correo si todas las variables tiene algo de contenido:
if($nombre != '' && $mail != '' && $mensaje != ''){
    mail($dest,$asunto,$cuerpo,$headers); //ENVIAR!
}
?>