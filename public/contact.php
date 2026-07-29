<?php
declare(strict_types=1);

// Endpoint de contacto (sponsors). Recibe el POST del formulario y envía
// el correo a través del SMTP propio de Hostinger usando PHPMailer.
// Requiere: public/lib/PHPMailer/{Exception,PHPMailer,SMTP}.php y public/mail-config.php

header('Content-Type: application/json; charset=utf-8');

// Solo se acepta POST
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
    exit;
}

// Honeypot anti-spam: si el campo oculto viene lleno, es un bot. Cortamos en silencio.
if (trim((string)($_POST['website'] ?? '')) !== '') {
    echo json_encode(['ok' => true]);
    exit;
}

// Datos del formulario
$nombre   = trim((string)($_POST['nombre'] ?? ''));
$empresa  = trim((string)($_POST['empresa'] ?? ''));
$email    = trim((string)($_POST['email'] ?? ''));
$telefono = trim((string)($_POST['telefono'] ?? ''));
$mensaje  = trim((string)($_POST['mensaje'] ?? ''));

// Validación mínima (coincide con los campos required del form)
$campos = [];
if ($nombre === '') {
    $campos[] = 'nombre';
}
if ($empresa === '') {
    $campos[] = 'empresa';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $campos[] = 'email';
}

if ($campos) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Revisá los datos del formulario.', 'campos' => $campos]);
    exit;
}

require __DIR__ . '/lib/PHPMailer/Exception.php';
require __DIR__ . '/lib/PHPMailer/PHPMailer.php';
require __DIR__ . '/lib/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$config = require __DIR__ . '/mail-config.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = $config['host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $config['username'];
    $mail->Password   = $config['password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // puerto 465
    $mail->Port       = (int) $config['port'];
    $mail->CharSet    = 'UTF-8';

    // El remitente debe ser del mismo dominio para pasar SPF/DKIM
    $mail->setFrom($config['from'], 'Web ALUQUINADA');
    $mail->addAddress($config['to']);
    $mail->addReplyTo($email, $nombre !== '' ? $nombre : $email);

    $mail->Subject = 'Nueva solicitud de sponsor — ' . $empresa;
    $mail->Body    =
        "Nombre: {$nombre}\n" .
        "Empresa: {$empresa}\n" .
        "Email: {$email}\n" .
        "Teléfono: {$telefono}\n\n" .
        "Mensaje:\n{$mensaje}\n";

    $mail->send();
    echo json_encode(['ok' => true]);
} catch (Exception $e) {
    http_response_code(500);
    // No exponemos detalles internos al cliente; el error real queda en el log del servidor.
    error_log('ContactForm mail error: ' . $mail->ErrorInfo);
    echo json_encode(['ok' => false, 'error' => 'No se pudo enviar el mensaje. Intentá más tarde.']);
}
