<?php
// Guardar los datos recibidos en variables:
$nombre = $_POST['nombre'];
$mail = $_POST['mail'];
$motivo = $_POST['motivo'];
$mensaje = $_POST['mensaje'];
$id = $_POST['id'];

$dest="info@shancla.com";
 
// Estas son cabeceras que se usan para evitar que el correo llegue a SPAM:
$headers = "From: $nombre $email\r\n";
$headers .= "X-Mailer: PHP5\n";
$headers .= 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Aqui definimos el asunto y armamos el cuerpo del mensaje
$asunto = "Contacto";
$cuerpo = "Nombre: ".$nombre."<br>";
$cuerpo .= "Email: ".$mail."<br>";
$cuerpo .= "Motivo: ".$motivo."<br>";
$cuerpo .= "ID: ".$id."<br>";
$cuerpo .= "Mensaje: ".$mensaje;
 
// Esta es una pequena validación, que solo envie el correo si todas las variables tiene algo de contenido:
if($nombre != '' && $mail != '' && $mensaje != ''){
    mail($dest,$asunto,$cuerpo,$headers); //ENVIAR!
}
?>