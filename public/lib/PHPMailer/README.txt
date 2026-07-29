Colocá aquí los 3 archivos de PHPMailer (solo la carpeta src/ de la librería):

  - Exception.php
  - PHPMailer.php
  - SMTP.php

Cómo obtenerlos (sin Composer, ideal para hosting compartido):

  1. Entrá a https://github.com/PHPMailer/PHPMailer/releases
  2. Descargá el "Source code (zip)" de la última versión estable.
  3. Del zip, abrí la carpeta `src/` y copiá esos 3 archivos EXACTAMENTE en esta carpeta
     (public/lib/PHPMailer/), quedando:
        public/lib/PHPMailer/Exception.php
        public/lib/PHPMailer/PHPMailer.php
        public/lib/PHPMailer/SMTP.php

Estos archivos son de terceros (licencia LGPL-2.1) y no se versionan en este repo.
Se suben al hosting junto con el resto del contenido de dist/.

Alternativa con Composer (si tu hosting/entorno tiene SSH + Composer):
  composer require phpmailer/phpmailer
  y ajustá los require de contact.php a vendor/autoload.php
