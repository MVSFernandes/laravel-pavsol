# PavSol Store Locator

PavSol is a Laravel application for earthmoving engineers who need to find nearby stores that sell construction and earthmoving materials. The dashboard uses Google Maps and the Google Places API to search suppliers around the user's location, show them on a map, and save useful stores as favorites.

## Stack

- Laravel 12
- PHP 8.2
- Blade
- SQLite
- Laravel UI
- Google Maps JavaScript API
- Google Places API
- Bootstrap 5

## Features

- Nearby store search for earthmoving and construction materials
- Interactive dashboard map with Google Maps markers
- Google Places text search biased around the user's current position
- Favorite stores saved per authenticated user
- Store routes through Google Maps directions
- Email-based two-factor authentication with a one-time code
- SQLite database for local development

## Installation

1. Install PHP dependencies:

   ```bash
   composer install
   ```

2. Install frontend dependencies:

   ```bash
   npm install
   ```

3. Copy the environment file:

   ```bash
   cp .env.example .env
   ```

   On Windows PowerShell:

   ```powershell
   Copy-Item .env.example .env
   ```

4. Generate the Laravel application key:

   ```bash
   php artisan key:generate
   ```

5. Create the SQLite database file if it does not exist:

   ```bash
   touch database/database.sqlite
   ```

   On Windows PowerShell:

   ```powershell
   New-Item -ItemType File -Path database/database.sqlite -Force
   ```

6. Run the migrations:

   ```bash
   php artisan migrate
   ```

7. Build frontend assets:

   ```bash
   npm run build
   ```

8. Add your own Google Maps API key in `resources/views/dashboard.blade.php`, replacing `YOUR_GOOGLE_MAPS_API_KEY`. The map and Places search require a valid key with the Google Maps JavaScript API and Places API enabled.

9. Start the development server:

   ```bash
   php artisan serve
   ```

The application will be available at the URL printed by Artisan, usually `http://127.0.0.1:8000`.

## Environment Notes

The project is configured to use SQLite by default:

```env
DB_CONNECTION=sqlite
```

Email delivery is required for the two-factor login code. Configure the `MAIL_*` variables in your local `.env` file with your own SMTP provider when testing the authentication flow.
