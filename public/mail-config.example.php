<?php
// PLANTILLA de configuración del correo.
//
// 1. Copiá este archivo como `mail-config.php` (en la misma carpeta).
// 2. Completá los valores reales con la cuenta de Hostinger.
// 3. NO subas `mail-config.php` a git (ya está en .gitignore).
//
// Datos SMTP de Hostinger: hPanel → Correos → tu cuenta → "Configuración".

return [
    'host'     => 'smtp.hostinger.com',
    'port'     => 465, // SMTPS (SSL). Alternativa: 587 con ENCRYPTION_STARTTLS en contact.php
    'username' => 'info@excellenceproducciones.com',
    'password' => 'TU_CONTRASENA_DEL_BUZON',
    'from'     => 'info@excellenceproducciones.com', // mismo dominio (SPF/DKIM)
    'to'       => 'info@excellenceproducciones.com', // a dónde llegan las solicitudes
];
