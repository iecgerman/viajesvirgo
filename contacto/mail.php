<?php
    if($_SERVER['REQUEST_METHOD'] != 'POST' ) {
        header("Location: index.html");
}


$nombre   = $_POST['nombre'];
$email    = $_POST['email'];
$celular  = $_POST['celular'];
$mensaje  = $_POST['mensaje'];


if( empty(trim($nombre)) ) $nombre = 'anonimo';
// if( empty(trim($apellido)) ) $apellido = '';

$body = <<<HTML
    <h1>Datos del cliente:</h1>
    <p>De: $nombre / $celular / $email / </p>
    <h2>Mensaje del cliente:</h2>
    $mensaje
HTML;

$headers = "MIME-Version: 1.0 \r\n";
$headers.= "Content-type: text/html; charset=utf-8 \r\n";
$headers.= "From: $nombre <$email> \r\n";
$headers.= "To: Blanca García <ventas@viajesvirgo.com> \r\n";


$rta = mail('ventas@viajesvirgo.com', "CLIENTE NUEVO: $mensaje", $body, $headers );

header("Location: gracias.html");