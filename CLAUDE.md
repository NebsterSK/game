# CLAUDE.md

- This project is located in `E:/webs/game`.

## Project Overview

Turn-based space strategy game built with Laravel 12 and Livewire 4. Players manage space colonies, assign crew (builders, engineers, scientists), and build assets.

## Tech Stack

- **Backend:** PHP 8.5, Laravel 12, Livewire 4
- **Frontend:** Blade templates, Alpine.js, FastBootstrap (dark theme)
- **Build:** Vite 6 with Sass/SCSS
- **Database:** SQLite (default), Eloquent ORM
- **Queue:** Database driver

## Commands

```bash
composer dev          # Start dev server, queue worker, and Vite
composer test         # Run PHPUnit tests (clears config first)
composer pint         # Format code with Laravel Pint
npm run build         # Build production assets
npm run watch         # Watch assets for changes
php artisan migrate   # Run database migrations
```

## Project Structure

- `app/Models/` — Eloquent models (User, Colony, Asset, ColonyAsset)
- `app/Livewire/` — Reactive Livewire components; `Game.php` is the main game component
- `app/Livewire/Traits/` — Trait composition (Builders, Engineers, Scientists)
- `app/Enums/` — PHP enums (AssetType, CrewType)
- `app/Events/` — Event classes (AssetFinished, TurnEnded)
- `app/Listeners/` — Event listeners for game logic
- `app/Services/` — Business logic (GameService)
- `config/game.php` — Game-specific configuration (starting_earth_date, base_work_per_turn)
- `resources/views/livewire/` — Livewire Blade templates
- `resources/sass/` — SCSS stylesheets
- `database/migrations/` — Database schema migrations

## Architecture

- **Event-driven:** Game logic flows through Events and Listeners (e.g., TurnEnded, AssetFinished)
- **Livewire components:** Reactive UI with traits for crew-type-specific logic
- **PHP Enums:** AssetType and CrewType for strongly-typed game values
- **UUID primary keys** on colonies

## Code Style

- **Formatter:** Laravel Pint with `"preset": "laravel"` (PSR-12 + Laravel conventions)
- **Indentation:** 4 spaces
- **Naming:** PascalCase classes, camelCase methods/properties, snake_case DB columns
- **PHP attributes:** `#[Locked]`, `#[Computed]`, `#[Validate]` for Livewire
- Always run `composer pint` before committing

## Testing

- **Framework:** PHPUnit 12
- **Test DB:** In-memory SQLite
- **Suites:** `tests/Feature/` and `tests/Unit/`
- Run with: `composer test`
