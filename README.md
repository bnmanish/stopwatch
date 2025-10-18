# Stopwatch

A web-based stopwatch application built with Laravel that tracks user interactions and visit analytics.

## Features

- **Stopwatch Functionality**: Start, stop, reset, and split time tracking with a visual rotating bullet indicator.
- **Split Times**: Record and display split times in a table.
- **Responsive Design**: Built with Bootstrap for mobile and desktop compatibility.
- **Visit Analytics**: Automatically tracks user visits including:
  - Device type (mobile/desktop)
  - User agent
  - IP address
  - Geolocation (latitude/longitude)
  - Time spent on the page
  - Visit timestamp

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/stopwatch.git
   cd stopwatch
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node.js dependencies:
   ```bash
   npm install
   ```

4. Copy the environment file and configure:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Run database migrations:
   ```bash
   php artisan migrate
   ```

6. Build assets:
   ```bash
   npm run build
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

## Usage

- Access the application in your browser at `http://localhost:8000`
- Click "Start" to begin the stopwatch
- Click "Split" to record split times while running
- Click "Stop" to pause the stopwatch
- Click "Reset" to reset the stopwatch and clear splits

Visit data is automatically collected and stored in the database when users leave the page.

## Technologies Used

- **Laravel 12**: PHP framework for backend
- **PHP 8.2+**: Server-side language
- **Tailwind CSS 4**: CSS framework for styling (welcome page)
- **Bootstrap 5.3**: CSS framework for styling (stopwatch page)
- **JavaScript (ES6+)**: Client-side stopwatch logic
- **Vite 7**: For asset building
- **Axios 1.11**: For HTTP requests
- **Geolocation API**: For capturing user location
- **SendBeacon API**: For reliable data transmission on page unload
- **Node.js**: For building assets

## Database

The application uses a `user_visits` table to store visit analytics. Migration is included in `database/migrations/`.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).