# Formulario de contacto (sponsors) — envío por correo

El formulario de [ContactForm.astro](src/components/ContactForm.astro) envía las solicitudes a
`info@excellenceproducciones.com` usando **PHPMailer** sobre el **SMTP propio de Hostinger**
(sin servicios de terceros). El sitio sigue siendo **estático**; solo se agrega un endpoint PHP
que Hostinger ejecuta.

## Piezas

| Archivo | Rol | ¿En git? |
|---|---|---|
| `public/contact.php` | Endpoint: valida, filtra spam (honeypot) y envía el mail. Devuelve JSON. | Sí |
| `public/mail-config.example.php` | Plantilla de credenciales SMTP. | Sí |
| `public/mail-config.php` | Credenciales **reales**. | No (`.gitignore`) |
| `public/lib/PHPMailer/*.php` | Librería de terceros (3 archivos). | No (`.gitignore`) |

El `<script>` del componente envía por `fetch` y muestra el estado (enviando / éxito / error)
sin recargar la página.

## Puesta en marcha (una sola vez)

1. **Crear la cuenta de correo** en Hostinger (hPanel → Correos) para
   `info@excellenceproducciones.com` y anotá la contraseña.

2. **Descargar PHPMailer** y copiar 3 archivos en `public/lib/PHPMailer/`
   (`Exception.php`, `PHPMailer.php`, `SMTP.php`). Ver
   [public/lib/PHPMailer/README.txt](public/lib/PHPMailer/README.txt).

3. **Crear las credenciales**: copiá `public/mail-config.example.php` como
   `public/mail-config.php` y completá `password` (y verificá host/puerto).

4. **Build y deploy**: `pnpm build`. Como los 3 puntos anteriores viven en `public/`,
   quedan incluidos en `dist/`. Subí el contenido de `dist/` a `public_html` en Hostinger.

## Notas

- **Seguridad (regla 13):** la contraseña vive solo en `public/mail-config.php`, que no se
  versiona. Al ser `.php`, Hostinger lo ejecuta (no expone el código fuente si alguien lo pide
  por URL). Aun así, no lo compartas ni lo subas a git.
- **Local:** en `pnpm dev` el envío **no** funciona (no hay PHP). Se prueba solo en Hostinger.
- **Puerto alternativo:** si el 465 (SSL) fallara, usá 587 cambiando en `contact.php`
  `ENCRYPTION_SMTPS` por `ENCRYPTION_STARTTLS` y `port` a 587 en `mail-config.php`.
- **Remitente:** `from` debe ser del dominio propio para pasar SPF/DKIM; el email del visitante
  va como `Reply-To`, así respondés directo desde tu bandeja.
