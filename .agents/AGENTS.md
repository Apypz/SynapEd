# SynapEd — AI Agent Master Instructions (AGENTS.md)

Welcome to the SynapEd project! As an AI coding assistant, you **MUST** adhere strictly to the following rules, conventions, and architectural constraints when generating, modifying, or reviewing code for this project. These rules are synthesized from the `document_context` specifications.

---

## 1. Project Architecture & Tech Stack
- **Framework**: Laravel 12 Monolith (PHP 8.2+).
- **Database**: SQLite (`database/database.sqlite`).
- **Frontend**: Blade Templating, Tailwind CSS (3.4.x), and Alpine.js (3.x).
- **Asset Bundler**: Vite (7.x).
- **Authentication**: Laravel Breeze (Session-based).
- **Strict Prohibitions**:
  - ❌ **DO NOT** suggest or implement Single Page Applications (SPA) like React, Vue, or Next.js.
  - ❌ **DO NOT** use Livewire.
  - ❌ **DO NOT** use other CSS frameworks (e.g., Bootstrap, Bulma) or heavy JS libraries like jQuery.
  - ❌ **DO NOT** migrate to MySQL/PostgreSQL without explicit user instruction.

---

## 2. Design & UI/UX Principles
- **Theme**: "Premium Dark Academic" (Dark base with bright accents to build trust and professional feel).
  - Background: Dark (`bg-base`), Cards (`bg-card`).
  - Text: White (`text-primary`), Gray (`text-secondary`).
  - Primary Brand: `#2563EB` (Blue), Secondary: `#7C3AED` (Purple), Accent: `#06B6D4` (Cyan).
- **Typography**: `Poppins` (700/600) for headings and buttons, `Figtree` (400) for body and captions.
- **Styling**: ONLY use Tailwind utility classes directly in Blade files. DO NOT write custom CSS unless strictly necessary for animations or overriding third-party styles.
- **Interactivity**: Use **Alpine.js** (`x-data`, `x-show`, etc.) for lightweight interactions (modals, dropdowns, tabs, accordions) without full page reloads. DO NOT use vanilla JS DOM manipulation if Alpine.js can handle it.

---

## 3. Code & Naming Conventions
- **Controllers**: `PascalCase` + `Controller` (e.g., `CourseController.php`). Follow the Single Responsibility Principle; use standard resource methods (`index`, `show`, `create`, `store`, `edit`, `update`, `destroy`).
- **Models (Eloquent)**: `PascalCase` (singular) (e.g., `Course.php`).
- **Database Tables**: `snake_case` (plural) (e.g., `courses`, `lessons`).
- **Database Columns**: `snake_case` (e.g., `created_at`, `course_id`).
- **Migrations**: Always create new migrations for schema changes. NEVER edit a migration that has already been run. Use timestamp prefix.
- **Blade Views**: `kebab-case` (e.g., `course-card.blade.php`).
- **Routes**: Use `dot.notation` (e.g., `courses.show`). All web routes go in `routes/web.php` (or `routes/auth.php` for Breeze auth). NO API routes unless explicitly requested.

---

## 4. Database & Logic
- **Eloquent Models**: Every table must have a corresponding Eloquent Model in `app/Models/`. Use `$fillable` for mass assignment (never `$guarded = []`). Define relationships explicitly (e.g., `hasMany`, `belongsTo`).
- **Controllers**: Keep controllers lean. Do not put heavy business logic in them; use Form Requests for validation (`php artisan make:request`), not inline validation in the controller.
- **Views (Blade)**: Do NOT perform database queries in Blade views. Pass all required data from the controller via `compact()` or `->with()`.
- **Data Migration Target**: The immediate roadmap involves migrating hardcoded data (`app/Helpers/LmsData.php`) into the SQLite database based on the target schema (`users`, `categories`, `courses`, `sections`, `lessons`, `enrollments`, etc.).

---

## 5. Security & Git
- **Security**: NEVER expose credentials. Rely on `.env`. Validate all user input server-side. Protect CSRF using `@csrf` in forms.
- **Git**: NEVER commit `.env`, `database.sqlite` (to production), or folders like `vendor/` and `node_modules/`.

---

## 6. Context Documents
For deep dives into specific areas, always refer to the following original documents located in `document_context/`:
- `1-architecture.md` - Core architecture and routing.
- `2-design.md` - UI, colors, typography, components, and Alpine.js rules.
- `3-prd.md` - Business goals, features, target users, and progress tracking.
- `4-rules.md` - Hard development constraints.
- `5-schema.md` - The exact target SQL schema.

> By following these rules, you will ensure a consistent, secure, and maintainable codebase for SynapEd, directly aligning with the project's vision.
