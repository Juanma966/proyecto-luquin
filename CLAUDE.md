# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Stack

- **Astro 7** (`output: static` by default — no server adapter configured).
- **Tailwind CSS 4**, wired in through the `@tailwindcss/vite` plugin in [astro.config.mjs](astro.config.mjs) (not a PostCSS/`tailwind.config` setup). Utility layers come from `@import "tailwindcss";` in [src/styles/global.css](src/styles/global.css).
- **pnpm** is the package manager (`pnpm-lock.yaml`). Requires **Node >= 22.12.0**.
- TypeScript uses Astro's `strict` preset ([tsconfig.json](tsconfig.json)).

## Commands

Run from the project root:

- `pnpm dev` — local dev server at `localhost:4321`
- `pnpm build` — production build to `./dist/`
- `pnpm preview` — serve the built site locally
- `pnpm astro ...` — Astro CLI (e.g. `pnpm astro add`, `pnpm astro check` for type-checking)

There is no test runner or linter configured; `pnpm astro check` is the type/diagnostics check.

### Dev server (background mode)

When starting the dev server, use background mode:

```
astro dev --background
```

Manage it with `astro dev stop`, `astro dev status`, and `astro dev logs`.

## Structure

- `src/pages/` — file-based routes (each `.astro` file is a page).
- `src/layouts/` — shared page shells wrapped around page content via `<slot />`.
- `src/components/` — reusable `.astro` components.
- `src/assets/` — images imported into components (processed by Astro's asset pipeline).
- `src/styles/global.css` — the single Tailwind entry point.
- `public/` — static files served as-is.

Note: [src/layouts/Layout.astro](src/layouts/Layout.astro) imports `global.css` (Tailwind entry) and accepts `title` (required) and `description` (optional) props for per-page SEO. Pages render inside it via `<slot />`.

## Documentation

Full docs: https://docs.astro.build. Consult these before related work:

- [Routing / pages / middleware](https://docs.astro.build/en/guides/routing/)
- [Astro components](https://docs.astro.build/en/basics/astro-components/)
- [Framework components (React, Vue, Svelte)](https://docs.astro.build/en/guides/framework-components/)
- [Content collections](https://docs.astro.build/en/guides/content-collections/)
- [Styling / Tailwind](https://docs.astro.build/en/guides/styling/)
- [Internationalization](https://docs.astro.build/en/guides/internationalization/)


#Mejoras propuestas por mi (Juan)
Development Rules - Luquin Event Landing Project
Objective
This document defines the mandatory rules that Claude must respect throughout the development of the project. The goal is to maintain a consistent architecture, clean code, up-to-date documentation, and a conversion-oriented approach.

1. Project Scope
The project consists of two Landing Pages: Landing Principal (event promotion and ticket sales) and Landing Sponsors (attracting sponsors). It is not a web application nor does it have a backend.
2. Methodology
Before writing code, you should: Analyze → Design → Plan → Explain → Implement → Review → Optimize → Document.
3. Communication
Always answer in Latin American Spanish. Explain what it will do, why, affected files, and impact. Do not respond only with code.
4. Validation before deploying
Never assume requirements. If there is ambiguity or more than one valid solution, you should stop, explain the alternatives, and ask for approval before implementing.
5. Decision-making
Do not modify architecture, structure or functionalities on their own initiative. Always consult first.
6. Mobile First
Develop first for mobile (360-767px), then tablet (768-1023px) and finally desktop (1024px+).
7. Avoid over-engineering
Prioritize simple, reusable, and maintainable solutions. Avoid unnecessary patterns, premature abstractions, anticipated optimizations, and overly complex components.
8. Architecture
Respect the defined structure of the project. Reuse components before creating new ones. Apply SOLID, DRY, KISS and YAGNI.
9. Code
Clean, typed, consistent code, no duplication, unused imports, dead code or warnings.
10. Components
Each component will have a single responsibility. Named, descriptive and reusable.
11. Comments
Do not comment on obvious code. Comments are only allowed to mark the start and end of main sections, for example: <!-- Hero --> ... <!-- End Hero -->.
12. Documentation
Keep README, architecture, structure, roadmap and any technical documentation always updated when a functionality requires it.
13. Security
The project does not have a backend. Verify that API Keys, tokens, credentials, secrets, and sensitive information are never exposed. Use environment variables where appropriate.
14. UI/UX Design
Do not invent colors, typographies, images or iconography. Use placeholders until you receive official resources from the design team.
15. Conversion
Every decision should contribute to selling tickets, attracting sponsors, improving the user experience and optimizing performance.
16. Checklist obligatorio
Before finishing a task, check: Responsive, accessibility, SEO, performance, imports, TypeScript, Astro, documentation and absence of sensitive data.
17. Definition of Done
A task will only be completed when it works correctly, is responsive, accessible, documented, reusable and does not break existing functionality.

---

## Decisiones del proyecto (definidas con Juan)

Estas decisiones son la fuente de verdad del proyecto. No modificarlas por iniciativa propia; si algo entra en conflicto, detente y consulta (reglas 4 y 5).

- **Alcance:** dos landing pages estáticas, sin backend ni aplicación.
- **Estructura:** un único proyecto Astro con dos rutas — `/` (Landing Principal: promoción del evento y venta de entradas) y `/sponsors` (Landing Sponsors: captación de patrocinadores). Layout y componentes se comparten entre ambas.
- **Stack:** Astro puro + Tailwind CSS 4 por defecto. Se permite añadir una isla de framework (React/Vue/Svelte) solo para un caso puntual que lo justifique; no como opción por defecto.
- **Idioma:** el contenido del sitio va únicamente en español (sin i18n). La comunicación con el usuario es en español latinoamericano (regla 3).
- **Venta de entradas:** los CTA de compra enlazan a una **plataforma externa** de tickets. Hasta tener la URL real, usar `href="#"` como placeholder.
- **Contacto de sponsors:** formulario gestionado por un **servicio de terceros** (Formspree / Getform / Google Forms u similar), sin backend propio. Hasta definir el servicio, dejar el `action`/endpoint como placeholder.
- **Contenido y branding:** todo es placeholder (textos, datos del evento, colores, tipografías, imágenes, iconografía) hasta recibir los recursos oficiales del equipo de diseño (regla 14). Usar un sistema de placeholders neutro y fácil de reemplazar.
- **Deploy:** hosting estático en **Hostinger** con dominio propio `.com`. El build (`dist/`) se sube al hosting. El sitio vive en la raíz del dominio (sin base path) y **no** requiere adaptador de servidor; mantener la salida estática por defecto de Astro.
- **Commits:** los commits tienen que ser escritos como si yo los hiciera, sin ninguna referencia a claude o ia .
