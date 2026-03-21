# CLAUDE.md

## Project Overview

Turn-based space strategy game — a web-based colony management simulator. Players manage space colonies with crew types (Builders, Engineers, Scientists), assign them to work on assets (Buildings, Technologies, Researches), and progress through turns.

## Tech Stack

- **Backend:** PHP 8.5, Laravel 12.50
- **Frontend:** Livewire 3.7.8, Blade templates, Alpine.js
- **CSS:** FastBootstrap 2.2.0 (Bootstrap-based), SCSS
- **Build:** Vite 6.0
- **Database:** SQLite (default), MySQL supported
- **Testing:** PHPUnit 12.0

## Commands

```bash
# Development
composer run dev          # Start dev server + queue + Vite concurrently

# Testing
composer run test         # Clear config cache then run artisan test

# Linting / Code Style
composer run pint         # Run Laravel Pint (PER-2 / laravel preset)

# Build frontend
npm run build             # Production build
npm run watch             # Watch mode

# Database
php artisan migrate       # Run migrations
php artisan db:seed       # Run seeders

# IDE helpers
composer run models       # Regenerate model docblocks
```

## Architecture

- **Event-Driven:** Game state updates flow through Events (`TurnEnded`, `AssetFinished`) and Listeners (`ProgressBuilding`, `ProgressResearch`, `UpdateColony`)
- **Livewire Components:** Main game UI is `app/Livewire/Game.php` with traits for crew logic (`Builders`, `Engineers`, `Scientists`)
- **Enums:** `AssetType` (Building, Technology, Research) and `CrewType` (Builder, Engineer, Scientist) in `app/Enums/`
- **Models:** `User`, `Colony`, `Asset`, `ColonyAsset` in `app/Models/`
- **Game config:** `config/game.php` (starting date, base work per turn)

## Code Conventions

- **PHP style:** Laravel Pint with `laravel` preset (PER-2 standard)
- **Naming:** PascalCase classes, camelCase methods, $camelCase properties
- **Livewire:** Uses `#[Computed]`, `#[Validate]`, `#[Locked]` attributes; snake_case public properties
- **Controllers:** Thin — delegate logic to models/services/events
- **Tests:** Feature and Unit suites; SQLite in-memory; `RefreshDatabase` trait on base TestCase

## Testing

- Tests in `tests/Feature/` and `tests/Unit/`
- Uses SQLite `:memory:` database for test isolation
- Factories: `UserFactory`, `ColonyFactory`
- Queue runs synchronously in tests (`QUEUE_CONNECTION=sync`)
