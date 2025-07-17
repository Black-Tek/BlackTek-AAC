# BlackTek-AAC
An opinionated AAC for Black Tek Server, built with Laravel 12, using React as frontend (Inertia) and Tailwind for styling.

## Prerequisites
- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL
- Git

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/Black-Tek/BlackTek-AAC.git
   cd BlackTek-AAC
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node.js dependencies and build frontend:
   ```bash
   npm install && npm run build
   ```

4. Copy environment file and configure:
   ```bash
   cp .env.example .env
   ```
   Edit `.env` to set MySQL database credentials and other settings.

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Run database migrations:
   ```bash
   php artisan migrate
   ```

## Running the Project
1. Start the Laravel development server:
   ```bash
   composer run dev
   ```

2. Access the application at `http://localhost:8000`.
