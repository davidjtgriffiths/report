## Accessing the `davidgriffiths/report` Application

Once your Laravel Sail environment for `davidgriffiths/report` is up and running (`./vendor/bin/sail up -d`), your application services are built, the database is migrated, and frontend assets are compiled, you should be able to access the application through your web browser.

### Default URL

By default, Laravel Sail configures your `davidgriffiths/report` application to be accessible at:

**`http://localhost`**

This works because Sail, by default, maps port 80 of the `laravel.test` container (where your application's web server, typically Nginx or Apache, runs) to port 80 on your host machine. Most web browsers default to port 80 if no port is specified in the URL, so simply typing `http://localhost` is usually sufficient. This assumes the `APP_PORT` variable in your `davidgriffiths/report` project's `.env` file is either not set, commented out, or explicitly set to `80`.

### Custom Port (Using `APP_PORT` in `.env`)

If you have customized the `APP_PORT` variable in your `davidgriffiths/report` project's `.env` file, the URL to access your application will change accordingly. For example, if you set:

```env
# In your .env file for davidgriffiths/report
APP_PORT=8000
```

Then your `davidgriffiths/report` application will be accessible at:

**`http://localhost:8000`**

Laravel Sail uses the `APP_PORT` variable from your project's `.env` file to determine which port on your host machine should be mapped to port 80 of the application container.

### Checking the Correct Port

The primary place to confirm the port for accessing your `davidgriffiths/report` application is the `APP_PORT` variable within its `.env` file.

1.  **Open the `.env` file** in the root of your `report` project directory.
2.  **Look for the `APP_PORT` variable.**
    *   If it's set (e.g., `APP_PORT=8000`), use that port: `http://localhost:8000`.
    *   If it's commented out (e.g., `# APP_PORT=8000`) or not present, Sail will use its default, which typically results in `http://localhost` (implying port 80) being the correct URL.
    *   If it's explicitly set to `APP_PORT=80`, then `http://localhost` is also the correct URL.

After navigating to the correct URL, you should see the homepage of your `davidgriffiths/report` application. This confirms that your local development environment using Laravel Sail is successfully set up and running.
