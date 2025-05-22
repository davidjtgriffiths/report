# Messaging and Issue Tracking Application

This is a web application built with Laravel and Vue.js that allows users to send messages and track associated issues. It provides features for user authentication, message management (including send frequency controls), and issue logging.

## Main Features

This application offers the following key features:

*   **User Authentication:**
    *   User registration and login.
    *   Password reset functionality.
    *   Profile management, allowing users to update their information.
*   **Messaging System:**
    *   Create and view messages.
    *   Send messages to specified email recipients.
    *   Messages can be associated with issues.
    *   A configurable restriction on message sending frequency (e.g., users can only send a new message after a certain number of days since their last sent message).
*   **Issue Tracking:**
    *   Create and view issues with a title and description.
    *   Issues are linked to the user who created them.
    *   Messages can be associated with specific issues, allowing for contextual communication.

## Technologies Used

*   **Backend:**
    *   PHP
    *   Laravel Framework
*   **Frontend:**
    *   Vue.js
    *   Tailwind CSS
    *   Inertia.js (for building a single-page application experience)
*   **Database:**
    *   Eloquent ORM (Laravel's default ORM, compatible with MySQL, PostgreSQL, SQLite, SQL Server)
*   **Key Packages & Tools:**
    *   Laravel Sanctum (for API token authentication)
    *   Laravel Telescope (for debugging and application insight)
    *   Ziggy (for using Laravel routes in JavaScript)
    *   Vite (for frontend asset bundling)

## Project Setup

To set up and run this project locally, follow these steps:

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    cd <repository-directory>
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Install JavaScript dependencies:**
    ```bash
    npm install
    ```

4.  **Set up environment file:**
    *   Copy the example environment file:
        ```bash
        cp .env.example .env
        ```
    *   Generate an application key:
        ```bash
        php artisan key:generate
        ```
    *   Configure your database connection and other environment variables (e.g., `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `MAIL_MAILER`) in the `.env` file.

5.  **Run database migrations:**
    ```bash
    php artisan migrate
    ```
    *(Optional: If you want to seed the database with some initial data, you might need to run `php artisan db:seed` if seeders are configured).*

6.  **Build frontend assets:**
    *   For development (with hot-reloading):
        ```bash
        npm run dev
        ```
    *   For production:
        ```bash
        npm run build
        ```

7.  **Serve the application:**
    ```bash
    php artisan serve
    ```
    The application should now be accessible at `http://localhost:8000` (or another port if specified).

## Contributing

Contributions are welcome! If you'd like to contribute to this project, please feel free to fork the repository, make your changes, and submit a pull request.
