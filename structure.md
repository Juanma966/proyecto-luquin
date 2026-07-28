# Estructura de la app

Documento de referencia para entender y modificar cómo está distribuida la aplicación.
Mantener actualizado cuando se agreguen, quiten o reordenen páginas o secciones (regla 12).

## Visión general

Sitio estático en Astro con **dos landing pages** (sin backend):

- **`/` — Landing Principal:** promoción del evento y venta de entradas.
- **`/sponsors` — Landing Sponsors:** captación de patrocinadores.

Ambas comparten el mismo `Layout` y los componentes de `src/components/`.

## Rutas (páginas)

| Ruta | Archivo | Estado |
| :--- | :--- | :--- |
| `/` | [src/pages/index.astro](src/pages/index.astro) | En construcción (estructura base lista) |
| `/sponsors` | [src/pages/sponsors.astro](src/pages/sponsors.astro) | Estructura base completa (contenido placeholder) |

## Layout

[src/layouts/Layout.astro](src/layouts/Layout.astro) — shell HTML común.
Importa `global.css`, define `lang="es"` y recibe props:

- `title` (obligatoria) — `<title>` de la página.
- `description` (opcional) — meta description para SEO.

El contenido de cada página se inyecta con `<slot />`.

## Componentes y secciones

Cada componente es una sección con responsabilidad única (regla 10).

| Componente | Sección | Usado en | Función |
| :--- | :--- | :--- | :--- |
| [Header.astro](src/components/Header.astro) | Header | `/` | Barra superior sticky: brand + navegación (Inicio · Evento · Sponsor) + CTA "Entradas". |
| [Hero.astro](src/components/Hero.astro) | Hero | `/` | Imagen de fondo (`hero-luquin.webp`) con overlay oscuro; título, fecha/lugar, CTA principal (entradas) + secundario (→ `#evento`). |
| [AboutEvent.astro](src/components/AboutEvent.astro) | ¿De qué trata el evento? (`#evento`) | `/` | Introducción + carrusel horizontal de 3 actividades placeholder (texto a la izquierda, imagen a la derecha). |
| [Speaker.astro](src/components/Speaker.astro) | Josué Luquin (`#expositor`) | `/` | Presentación del expositor: imagen placeholder + biografía/trayectoria. |
| [Partners.astro](src/components/Partners.astro) | Empresas que nos acompañan | `/` | Carrusel de logos placeholder (marquee CSS auto, sin JS). |
| [Venue.astro](src/components/Venue.astro) | Hotel Hilton (`#hotel`) | `/` | Galería con fotos reales del hotel (`astro:assets`, scroll-snap deslizable, sin JS) + botón "¿Cómo llegar?" a Google Maps. |
| [BecomeSponsor.astro](src/components/BecomeSponsor.astro) | Sponsor (`#sponsor`) | `/` | Intro leve + imágenes placeholder + botón "Ser sponsor" → `/sponsors`. |
| [Tickets.astro](src/components/Tickets.astro) | Entradas (`#entradas`) | `/` | Intro leve + imágenes placeholder + botón a la **plataforma externa** de venta. |
| [Footer.astro](src/components/Footer.astro) | Footer | `/`, `/sponsors` | Compartido. Navegación (anclas absolutas `/#...`), enlace a `/sponsors`, redes placeholder y copyright. |

### Componentes de la Landing Sponsors (`/sponsors`)

| Componente | Sección | Función |
| :--- | :--- | :--- |
| [SponsorHeader.astro](src/components/SponsorHeader.astro) | Header | Brand + enlace a Inicio (`/`) + CTA "Solicitar información" (→ `#contacto`). |
| [SponsorHero.astro](src/components/SponsorHero.astro) | Hero Comercial | Propuesta comercial + CTA al formulario. |
| [WhySponsor.astro](src/components/WhySponsor.astro) | ¿Por qué ser Sponsor? | Grilla de ventajas (alcance, visibilidad, networking, público). |
| [CommercialSpaces.astro](src/components/CommercialSpaces.astro) | Espacios Comerciales | Carrusel de 3 partes (plano general + distribución x2), scroll-snap CSS. Imágenes ampliables con GLightbox (lightbox + swipe entre ellas), lazy loading. |
| [Stands.astro](src/components/Stands.astro) | Nuestros Stands | Cards de tipos de stand (render placeholder + medidas/características). |
| [SponsorTiers.astro](src/components/SponsorTiers.astro) | Categorías (`#categorias`) | Cards Platinum/Gold/Silver/Bronze con beneficios y CTA. |
| [CommercialBenefits.astro](src/components/CommercialBenefits.astro) | Beneficios Comerciales | 7 beneficios con marcador/ícono placeholder. |
| [ContactForm.astro](src/components/ContactForm.astro) | Formulario (`#contacto`) | Form con servicio de terceros (endpoint placeholder) + enlace a vendedor. |
| [SponsorFaq.astro](src/components/SponsorFaq.astro) | Preguntas Frecuentes | Acordeón nativo `<details>` (sin JS). |

### Orden de secciones

**Landing Principal (`/`):**

```
Header → Hero → ¿De qué trata el evento? → Josué Luquin → Empresas que nos acompañan
→ Hotel Hilton → Sponsor → Entradas → Footer
```

**Landing Sponsors (`/sponsors`):**

```
Header Sponsors → Hero Comercial → ¿Por qué ser Sponsor? → Espacios Comerciales
→ Nuestros Stands → Categorías de Sponsors → Beneficios Comerciales → Formulario de Contacto
→ Preguntas Frecuentes → Footer
```

## Estilos y design tokens

- Tailwind CSS 4 vía `@tailwindcss/vite`. Entrada única: [src/styles/global.css](src/styles/global.css).
- **Tema oscuro:** fondo negro global y texto claro por defecto (regla base en `body` dentro de `@layer base` de `global.css`). Las secciones no llevan fondo propio (heredan el negro); las tarjetas usan `bg-neutral-900` con `border-neutral-800`.
- **Tokens** en el bloque `@theme` de `global.css`:
  - `--color-brand` → `#ffff99` (color secundario / acento y CTA principal). Utilidades: `bg-brand`, `text-brand`, `border-brand`, `ring-brand`. Se usa en CTAs principales, eyebrows y detalles destacados.
  - `--color-brand-contrast` → texto oscuro sobre el acento amarillo. Utilidad: `text-brand-contrast`.
  - `--color-tertiary` → `#5c5c5c` (relleno de botones secundarios). Utilidades: `bg-tertiary`, `text-tertiary`.
- Textos: cuerpo en `text-neutral-300`, secundarios en `text-neutral-400`, títulos heredan el claro del `body`.
- **Mobile-first:** clases base para móvil (360px+), luego `sm:` (768px+) y `lg:` (1024px+).

## Placeholders e integraciones pendientes

- **Venta de entradas:** el botón de la sección Entradas enlaza a una plataforma externa. Hoy `href="#"` hasta tener la URL real.
- **Imágenes:** bloques neutros (`bg-neutral-800`) como placeholder hasta recibir las imágenes oficiales.
- **Contacto de sponsors:** en la landing `/sponsors` se usará un formulario con servicio de terceros (Formspree/Getform u similar); endpoint como placeholder hasta definirlo.
- **Branding:** textos, colores, tipografías, imágenes e iconografía son placeholder hasta recibir los recursos oficiales.

## Cómo agregar o modificar una sección

1. Crear/editar el componente en `src/components/` (una responsabilidad por componente).
2. Importarlo y ubicarlo en la página correspondiente (`src/pages/`).
3. Envolver el bloque con comentarios de sección: `<!-- Nombre --> ... <!-- End Nombre -->` (regla 11).
4. Mantener mobile-first y reutilizar los tokens `brand` para acentos.
5. Actualizar este documento con el cambio.
