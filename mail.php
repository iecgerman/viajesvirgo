<?php
// Solo se acepta el envío del formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /');
    exit;
}

// Anti-spam: los bots llenan este campo oculto; fingimos éxito y no enviamos nada
if (!empty($_POST['web'])) {
    header('Location: /#gracias');
    exit;
}

// Quita saltos de línea para evitar inyección de encabezados
function limpiar($valor) {
    return trim(str_replace(["\r", "\n"], ' ', (string) $valor));
}

// Escapa HTML para que nadie meta código en el correo
function h($valor) {
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

$nombre  = limpiar($_POST['nombre'] ?? '');
$email   = limpiar($_POST['email'] ?? '');
$celular = limpiar($_POST['celular'] ?? '');
$mensaje = trim((string) ($_POST['mensaje'] ?? ''));

if ($nombre === '') {
    $nombre = 'anonimo';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: /#error');
    exit;
}

$body = '<h1>Datos del cliente:</h1>'
      . '<p>De: ' . h($nombre) . ' / ' . h($celular) . ' / ' . h($email) . '</p>'
      . '<h2>Mensaje del cliente:</h2>'
      . '<p>' . nl2br(h($mensaje)) . '</p>';

// Remitente fijo del dominio (llega mejor a la bandeja); el cliente va en Reply-To
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: Viajes Virgo <ventas@viajesvirgo.com>\r\n";
$headers .= "Reply-To: $email\r\n";

$asunto = '=?UTF-8?B?' . base64_encode('CLIENTE NUEVO: ' . $nombre) . '?=';

$enviado = mail('ventas@viajesvirgo.com', $asunto, $body, $headers);

header('Location: ' . ($enviado ? '/#gracias' : '/#error'));
exit;
