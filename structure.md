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
| `/sponsors` | [src/pages/sponsors.astro](src/pages/sponsors.astro) | Placeholder (pendiente de contenido) |

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
| [Hero.astro](src/components/Hero.astro) | Hero | `/` | Título, fecha/lugar, CTA principal (entradas) + secundario (→ `#evento`). |
| [AboutEvent.astro](src/components/AboutEvent.astro) | ¿De qué trata el evento? (`#evento`) | `/` | Introducción + 3 actividades placeholder. |
| [Speaker.astro](src/components/Speaker.astro) | Josué Luquin (`#expositor`) | `/` | Presentación del expositor: imagen placeholder + biografía/trayectoria. |
| [Partners.astro](src/components/Partners.astro) | Empresas que nos acompañan | `/` | Carrusel de logos placeholder (marquee CSS auto, sin JS). |
| [Venue.astro](src/components/Venue.astro) | Hotel Hilton (`#hotel`) | `/` | Galería de imágenes placeholder (scroll-snap deslizable, sin JS) + descripción. |
| [BecomeSponsor.astro](src/components/BecomeSponsor.astro) | Sponsor (`#sponsor`) | `/` | Intro leve + imágenes placeholder + botón "Ser sponsor" → `/sponsors`. |
| [Tickets.astro](src/components/Tickets.astro) | Entradas (`#entradas`) | `/` | Intro leve + imágenes placeholder + botón a la **plataforma externa** de venta. |
| [Footer.astro](src/components/Footer.astro) | Footer | `/` | Navegación interna, enlace a `/sponsors`, redes placeholder y copyright. |

### Orden de secciones

**Landing Principal (`/`):**

```
Header → Hero → ¿De qué trata el evento? → Josué Luquin → Empresas que nos acompañan
→ Hotel Hilton → Sponsor → Entradas → Footer
```

**Landing Sponsors (`/sponsors`):** pendiente de definir su composición de secciones.

## Estilos y design tokens

- Tailwind CSS 4 vía `@tailwindcss/vite`. Entrada única: [src/styles/global.css](src/styles/global.css).
- **Tokens placeholder** en el bloque `@theme` de `global.css` (reemplazar por el branding oficial, regla 14):
  - `--color-brand` → color de acento (CTAs). Utilidades: `bg-brand`, `text-brand`, `border-brand`, `ring-brand`.
  - `--color-brand-contrast` → color de texto sobre el acento. Utilidad: `text-brand-contrast`.
- El resto usa la paleta **neutral** de Tailwind como placeholder.
- **Mobile-first:** clases base para móvil (360px+), luego `sm:` (768px+) y `lg:` (1024px+).

## Placeholders e integraciones pendientes

- **Venta de entradas:** el botón de la sección Entradas enlaza a una plataforma externa. Hoy `href="#"` hasta tener la URL real.
- **Imágenes:** bloques neutros (`bg-neutral-200`) como placeholder hasta recibir las imágenes oficiales.
- **Contacto de sponsors:** en la landing `/sponsors` se usará un formulario con servicio de terceros (Formspree/Getform u similar); endpoint como placeholder hasta definirlo.
- **Branding:** textos, colores, tipografías, imágenes e iconografía son placeholder hasta recibir los recursos oficiales.

## Cómo agregar o modificar una sección

1. Crear/editar el componente en `src/components/` (una responsabilidad por componente).
2. Importarlo y ubicarlo en la página correspondiente (`src/pages/`).
3. Envolver el bloque con comentarios de sección: `<!-- Nombre --> ... <!-- End Nombre -->` (regla 11).
4. Mantener mobile-first y reutilizar los tokens `brand` para acentos.
5. Actualizar este documento con el cambio.
