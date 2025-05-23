# Laravel Local Development Tutorial: Sail and Docker

## Introduction to the Tutorial

This tutorial will guide you through the process of setting up a Laravel project locally using Docker and Laravel Sail. We'll cover the prerequisites, installation steps, and how to get your development environment up and running smoothly.

We recommend using Visual Studio Code (VS Code) as your code editor for this tutorial. VS Code offers excellent integration with Docker development, providing a seamless experience for managing your containers and developing your Laravel application.

## Prerequisites

Before you begin, ensure you have the following software installed on your system:

*   **Git:** A version control system for tracking changes and collaborating on projects. You can download it from [https://git-scm.com/downloads](https://git-scm.com/downloads).
*   **Docker Desktop:** Simplifies the setup and management of Docker environments on Mac and Windows. Download it from [https://www.docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop).
    *   **For Linux Users:** You'll need to install Docker Engine and Docker Compose separately.
        *   Install Docker Engine: [https://docs.docker.com/engine/install/](https://docs.docker.com/engine/install/)
        *   Install Docker Compose: [https://docs.docker.com/compose/install/](https://docs.docker.com/compose/install/)
*   **Visual Studio Code (VS Code):** A lightweight but powerful source code editor. Download it from [https://code.visualstudio.com/download](https://code.visualstudio.com/download).
*   **VS Code 'Remote - Containers' Extension:** This extension is crucial for working with Dockerized applications in VS Code. It allows you to open any folder inside (or mounted into) a container and take advantage of VS Code's full feature set. You can install it from the VS Code Marketplace.
*   **Recommended VS Code Extensions for Laravel Development:**
    *   **PHP Intelephense:** Advanced PHP IntelliSense for VS Code.
    *   **Laravel Extension Pack:** A collection of popular extensions for Laravel development.
    *   **Prettier - Code formatter:** An opinionated code formatter that helps maintain consistent code style.

## Cloning the Repository

To get started, you'll need to clone the project repository to your local machine. Open your terminal or command prompt and run the following command:

```bash
git clone <repository-url>
```

Replace `<repository-url>` with the actual URL of the project repository.

Once the cloning process is complete, navigate into the newly created project directory:

```bash
cd <project-directory-name>
```

Replace `<project-directory-name>` with the name of the directory that was created when you cloned the repository (it's usually the name of the repository itself).

## Setting up Laravel Sail

Laravel Sail is a light-weight command-line interface for interacting with Laravel's default Docker development environment. It provides a great starting point for building Laravel applications using Docker without requiring extensive Docker experience.

### 1. Navigate into Your Project Directory

If you're not already there, make sure you are in the root directory of your cloned Laravel project:

```bash
cd <project-directory-name>
```
*(Replace `<project-directory-name>` with the actual name of your project directory if you haven't already navigated into it).*

### 2. Install PHP Dependencies (including Sail)

Next, you'll install the project's PHP dependencies, which include Laravel Sail, using Composer:

```bash
composer install
```

This command reads the `composer.json` file and downloads all the necessary packages into the `vendor` directory.

### 3. Publish Sail's Docker Compose File

After Composer finishes installing the packages, you need to publish Sail's `docker-compose.yml` file to your project's root directory. This file defines the services that will be part of your Docker environment. Run the following Artisan command:

```bash
php artisan sail:install
```

You might be prompted to choose which services you want to install (e.g., MySQL, PostgreSQL, Redis, Meilisearch, MailHog, etc.). For a standard setup, you can usually go with the defaults (e.g., selecting `mysql`, `redis`, `mailpit`).

### Default Services

Once the `sail:install` command is complete, a `docker-compose.yml` file will be present in your project root. This file typically configures the following services by default (depending on your selections during `sail:install`):

*   `laravel.test`: This is the main application container where your Laravel application runs.
*   `mysql` (or `pgsql`): The database service for your application.
*   `redis`: An in-memory data store, often used for caching and queues.
*   `mailpit` (or `mailhog`): A local email testing tool that catches emails sent by your application during development, so they don't go to actual email addresses.
*   Other services like `selenium` for browser testing or `meilisearch` for search might also be included if you selected them.

These services work together to provide a complete development environment for your Laravel application.

## Configuring the Environment

After installing Laravel Sail, the next step is to configure your application's environment. This involves creating an environment file and ensuring key settings are correctly configured for Docker and Sail.

### 1. Create Your Environment File

Laravel uses a `.env` file to store environment-specific settings and application secrets. This file is not committed to version control (as it's listed in `.gitignore`) to keep sensitive information secure.

You'll start by copying the example environment file:

```bash
cp .env.example .env
```

This command creates a new `.env` file in your project root, which your Laravel application will use.

### 2. Understanding the `.env` File

The `.env` file is crucial for your Laravel application. It allows you to define different configurations for different environments (local development, staging, production) without changing your codebase. It's where you'll store database credentials, API keys, application settings, and other sensitive information.

### 3. Key `.env` Variables for Laravel Sail

Laravel Sail pre-configures many of these variables to work seamlessly with its Docker services. Here are some of the key variables in your `.env` file and their typical values when using Sail:

*   `APP_NAME="Laravel"`: You can change this to your application's name.
*   `APP_ENV=local`: Sets the application environment to local.
*   `APP_DEBUG=true`: Enables debugging, which is useful for development. **Should be `false` in production.**
*   `APP_URL=http://localhost`: The base URL for your application. Sail maps port 80 of the `laravel.test` container to port 80 on your host machine by default.

*   **Database Connection (MySQL example):**
    *   `DB_CONNECTION=mysql`: Specifies that Laravel should use the MySQL driver.
    *   `DB_HOST=mysql`: **Important:** When using Sail, this should be the service name defined in `docker-compose.yml` (e.g., `mysql`, `pgsql`). Docker's internal network will resolve this name to the correct container.
    *   `DB_PORT=3306`: The default MySQL port.
    *   `DB_DATABASE=laravel`: The name of your database. Sail will create a database with this name.
    *   `DB_USERNAME=sail`: The default username Sail configures for the database.
    *   `DB_PASSWORD=password`: The default password Sail configures for the database. **You should change this for production environments.**

*   **Port Forwarding:**
    *   `FORWARD_DB_PORT=3306`: If you want to connect to your application's database from your local machine (e.g., using a GUI like TablePlus or DBeaver), Sail can forward the container's database port to a port on your host machine. If this is set to `3306`, you can connect to `127.0.0.1:3306`. If this variable is commented out or not present, the port won't be forwarded.
    *   `FORWARD_MAILPIT_PORT=8025`: Forwards Mailpit's web interface (if installed via `sail:install`).
    *   `FORWARD_REDIS_PORT=6379`: Forwards Redis port if you want to connect from the host.
    *   **Note:** While these forward ports allow access from your host machine, services within the Docker network (e.g., your Laravel application connecting to the database) communicate using their service names (`mysql`, `redis`) and internal Docker ports, not these forwarded ports.

### 4. Start the Docker Containers

Once your `.env` file is in place, you can start the Docker containers using Sail. This command builds and starts all the services defined in your `docker-compose.yml` file:

```bash
./vendor/bin/sail up -d
```

*   `./vendor/bin/sail`: This is the path to the Sail executable.
*   `up`: This is the Docker Compose command to start containers.
*   `-d`: This flag stands for "detached" mode, meaning the containers will run in the background, and your terminal will be free for other commands.

You might see output as Docker downloads images and builds your containers. This can take a few minutes the first time.

### 5. Generate Application Key

After the containers are running, you need to generate an application key for your Laravel project. This key is used for encryption and hashing and is vital for your application's security.

Run the following Sail command:

```bash
./vendor/bin/sail artisan key:generate
```

This command executes `php artisan key:generate` inside your application container and sets the `APP_KEY` variable in your `.env` file.

Your Laravel environment should now be configured and running! You can typically access your application by visiting `http://localhost` in your web browser.

## Database Migration and Seeding

Once your Docker containers are running and the application key is generated, the next step is to set up your database schema and optionally populate it with initial data.

### 1. Running Database Migrations

Database migrations are like version control for your database. They allow you to define your application's database schema (tables, columns, indexes, etc.) in PHP code. When you run the migrations, Laravel executes these definitions to create or modify your database tables.

To run your database migrations, use the following Sail command:

```bash
./vendor/bin/sail artisan migrate
```

This command will execute all pending migration files located in the `database/migrations` directory. You should see output in your terminal indicating which migrations were run.

### 2. Seeding the Database (Optional)

Database seeders are classes that can populate your database tables with initial or sample data. This is useful for development to have some data to work with, or for setting up default data required by the application.

If your project has database seeders configured for initial setup, you can run them using the following Sail command:

```bash
./vendor/bin/sail artisan db:seed
```

**Note:** Running seeders is optional and depends on the project's setup. Some projects might not require initial data seeding, or they might have specific seeders for different purposes.

If you want to use seeders or are unsure if you need to, you can check the project's `database/seeders/DatabaseSeeder.php` file. This file typically calls other seeder classes. You can also consult the project's documentation for guidance on database seeding. If the `DatabaseSeeder.php` file is empty or only contains commented-out examples, you likely don't need to run this command unless specifically instructed.

## Installing Frontend Dependencies and Building Assets

Modern web applications, including those built with Laravel, often rely on JavaScript and CSS for their user interfaces. These frontend dependencies are typically managed using Node Package Manager (NPM), and the assets (like CSS and JS files) need to be compiled or "built" to be used in the browser.

### 1. Install NPM Dependencies

Your Laravel project will have a `package.json` file that lists all the necessary JavaScript and CSS packages (e.g., Vue.js, React, Tailwind CSS, Bootstrap, etc.). To install these, you'll use NPM through Sail:

```bash
./vendor/bin/sail npm install
```

This command tells NPM to read the `package.json` and `package-lock.json` files and download the specified dependencies into a `node_modules` directory within your project.

### 2. Building Frontend Assets

Once the dependencies are installed, you need to compile your JavaScript and CSS. Laravel typically uses Vite or Laravel Mix (an abstraction over Webpack) for this. There are generally two types of builds:

*   **Development Build:** This build is optimized for development. It often includes features like Hot Module Replacement (HMR), which automatically refreshes your browser or injects changes without a full page reload as you modify your frontend code. Source maps are usually generated to make debugging easier.
*   **Production Build:** This build is optimized for production. It minifies code, removes unused assets (tree-shaking), and generates smaller, more efficient files for users to download.

#### For Development:

To compile your assets for development and usually start a development server with HMR, run:

```bash
./vendor/bin/sail npm run dev
```

This command will typically watch your frontend files (e.g., in `resources/js` and `resources/css`) for changes and automatically recompile them. If HMR is enabled, your browser will update almost instantly. You'll usually leave this command running in a separate terminal window while you're doing frontend development.

#### For Production:

When you are ready to deploy your application or want to test with production-like assets, you should generate a production build:

```bash
./vendor/bin/sail npm run build
```

This command compiles and optimizes your assets for production, typically placing them in the `public/build` directory (if using Vite) or a similar location specified in your build configuration. These are the files you would deploy to your production server. You generally run this command once as part of your deployment process.

## Accessing the Application

Once your Laravel Sail environment is up and running, your application services are built, and the database is migrated (and seeded if applicable), you should be able to access your application through a web browser.

### Default URL

By default, Laravel Sail configures your application to be accessible at:

**`http://localhost`**

This works because Sail, by default, maps port 80 of the `laravel.test` container (where your application's web server runs) to port 80 on your host machine. Most browsers will default to port 80 if no port is specified, so simply typing `http://localhost` is usually sufficient.

### Custom Port (Using `APP_PORT`)

If you have customized the `APP_PORT` variable in your `.env` file, the URL to access your application will change. For example, if you set:

```env
APP_PORT=8000
```

Then your application will be accessible at:

**`http://localhost:8000`**

Laravel Sail uses the `APP_PORT` variable from your `.env` file to determine which port on your host machine should be mapped to port 80 of the application container.

### How to Check the Port

If you're unsure which port your application is running on:

1.  **Check your `.env` file:** Look for the `APP_PORT` variable. If it's set and not empty, that's the port you should use (e.g., `http://localhost:YOUR_APP_PORT`). If it's commented out, not present, or set to `80`, then `http://localhost` (which implies port 80) is the correct URL.
2.  **Check `docker ps` (Advanced):** For more advanced users, you can use the `docker ps` command in your terminal. This command lists all running Docker containers. Look for the entry related to your application (often named something like `yourproject_laravel.test_1` or similar) and check the `PORTS` column. You should see an entry like `0.0.0.0:XXXX->80/tcp` or `:::XXXX->80/tcp`. The `XXXX` is the port number on your host machine that maps to port 80 in the container. This is the port you'd use in your browser (e.g., `http://localhost:XXXX`).

After navigating to the correct URL, you should see your Laravel application's homepage. Congratulations, your local development environment is set up!

## VS Code Integration with Docker

Visual Studio Code, when combined with the **Remote - Containers** extension (mentioned in the Prerequisites section), provides a powerful and seamless development experience for Dockerized applications like those set up with Laravel Sail.

### 1. Connecting to the Container

Once your Laravel Sail containers are running (`./vendor/bin/sail up -d`), you can open your project directly within the context of the application container (`laravel.test` service).

**Steps to Connect:**

1.  **Ensure 'Remote - Containers' is Installed:** Double-check that you have the "Remote - Containers" extension installed in VS Code.
2.  **Open Your Project in VS Code:** If you haven't already, open your Laravel project folder locally in VS Code as you normally would.
3.  **Reopen in Container:**
    *   Open the Command Palette:
        *   **Windows/Linux:** `Ctrl+Shift+P`
        *   **macOS:** `Cmd+Shift+P`
    *   Type `Dev Containers: Reopen in Container` and select it from the list.
    *   Alternatively, if VS Code detects the Dev Container configuration added by Sail (usually a `.devcontainer` folder), it might show a notification in the bottom right corner asking if you want to "Reopen in Container." You can click this button.
    *   If you don't have the project open yet, you can also use `Dev Containers: Open Folder in Container...` and select your project folder.

VS Code will then reload the window and connect to the `laravel.test` service defined in your `docker-compose.yml` file. The first time you do this, VS Code might need to build or configure the dev container, which can take a few minutes. Subsequent connections will be much faster.

Once connected, your VS Code interface will look the same, but you'll be operating *inside* the Docker container. You can verify this by looking at the bottom-left corner of the VS Code window, which should say something like "Dev Container: Laravel" or similar, indicating you're connected to the container.

### 2. Benefits of VS Code Container Integration

Working directly inside the container via VS Code offers several significant advantages:

*   **Integrated Terminal:** When you open a terminal in VS Code (`View > Terminal` or `Ctrl+\`), it will be a shell *inside* your `laravel.test` container. This means:
    *   You can run `php artisan` commands directly (e.g., `php artisan make:model Post`) without prefixing them with `./vendor/bin/sail`.
    *   You have direct access to PHP, Composer, Node.js, NPM, and any other tools installed within the container.
*   **Debugger Attachment:** You can easily set up and use Xdebug (or other PHP debuggers) to debug your Laravel application step-by-step directly within VS Code, just as you would with a local PHP installation.
*   **Seamless File Access:** You're editing the project files that are mounted into the container. Changes are reflected instantly, both in your local file system and inside the container.
*   **Extension Context:** VS Code extensions (like PHP Intelephense, Laravel-specific extensions, linters, etc.) run within the context of the container. This means they use the container's PHP version, libraries, and tools, providing more accurate autocompletion, linting, and error checking based on your actual development environment.
*   **Consistent Environment:** Ensures that your development environment in VS Code is identical to the environment your application runs in, reducing "works on my machine" issues.

This deep integration makes development smoother and more efficient, as you don't have to constantly switch contexts or run commands through Sail for common tasks.

## Running Tests

Automated tests are a crucial part of modern software development. They help ensure your application behaves as expected, prevent regressions when you make changes, and give you confidence in your codebase. Laravel comes with excellent built-in testing capabilities, primarily using PHPUnit.

### 1. Why Run Tests?

*   **Verify Correctness:** Tests confirm that your code produces the expected outcomes for given inputs.
*   **Prevent Regressions:** When you add new features or refactor existing code, tests can catch unintended side effects or breakages in other parts of the application.
*   **Facilitate Refactoring:** With a good test suite, you can refactor your code with more confidence, knowing that your tests will alert you if you've changed behavior in an unintended way.
*   **Documentation:** Tests can serve as a form of documentation, demonstrating how different parts of your application are intended to be used.

### 2. Running Your Project's Tests

Laravel Sail provides a straightforward way to run your project's PHPUnit tests. To execute the entire test suite, use the following command in your terminal, from the root of your project directory:

```bash
./vendor/bin/sail artisan test
```

This command will run all the tests found within your project's `tests/` directory. This typically includes:

*   **Feature tests** (in `tests/Feature`): These tests make HTTP requests to your application and assert the responses, testing your application from an "outside-in" perspective.
*   **Unit tests** (in `tests/Unit`): These tests focus on smaller, isolated pieces of your code, like individual methods within a class.

You will see output in your terminal indicating the progress and results of the tests (passes, failures, errors).

### 3. Running Specific Tests

Sometimes, you might not want to run the entire test suite, especially if you're working on a specific feature or debugging a particular test. You can run tests for a specific file or even a specific method.

**To run tests in a specific file:**

Provide the path to the test file relative to the project root:

```bash
./vendor/bin/sail artisan test tests/Feature/ExampleTest.php
```

(Replace `tests/Feature/ExampleTest.php` with the actual path to your test file.)

**To run a specific test method within a file:**

You can use the `--filter` option to specify the method name:

```bash
./vendor/bin/sail artisan test --filter=ExampleTest::test_the_application_returns_a_successful_response
```

(Replace `ExampleTest::test_the_application_returns_a_successful_response` with the actual class and method name from your test file.)

Running specific tests can save time during development and help you focus on the area you're currently working on. However, always ensure your entire test suite passes before committing or deploying changes.

## Troubleshooting Tips

Even with a streamlined setup like Laravel Sail, you might occasionally encounter issues. This section provides tips for common problems and how to resolve them.

### 1. Port Conflicts

*   **Issue:** Your application might not be accessible at `http://localhost` or `http://localhost:YOUR_APP_PORT`. This often happens if the port Sail wants to use (defined by `APP_PORT` in `.env`, commonly 80 or 8000 by default) is already in use by another application on your machine.
*   **How to Check (Simplified):** The easiest way is often to try a different port. However, advanced users can use tools like `netstat -tulnp | grep YOUR_PORT` (Linux/macOS) or `netstat -ano | findstr YOUR_PORT` (Windows) to see if a port is in use.
*   **Solution:**
    1.  Open your `.env` file.
    2.  Change the `APP_PORT` value to an unused port (e.g., `APP_PORT=8001`, `APP_PORT=8080`).
    3.  Save the `.env` file.
    4.  Stop and restart Sail to apply the changes:
        ```bash
        ./vendor/bin/sail down
        ./vendor/bin/sail up -d
        ```
    5.  Try accessing your application at `http://localhost:NEW_PORT`.

### 2. `./vendor/bin/sail` Command Not Found

*   **Issue:** You type a Sail command, and your terminal says "No such file or directory" or "command not found."
*   **Solutions:**
    *   **Ensure you're in the project root:** Sail commands must be run from the root directory of your Laravel project (where `vendor` and `artisan` are located).
    *   **Run `composer install`:** Sail is installed as a Composer dependency. If `composer install` was not run or failed, Sail won't be available. Run `composer install` and check for errors.
    *   **Check `docker-compose.yml`:** If the `docker-compose.yml` file is missing from your project root, run `php artisan sail:install` again to publish it. You might need to select your services (MySQL, Redis, etc.) again.

### 3. Docker Not Running

*   **Issue:** You see errors like "Cannot connect to the Docker daemon at unix:///var/run/docker.sock. Is the docker daemon running?" or similar messages indicating Docker isn't available.
*   **Solution:** Ensure Docker Desktop (on Mac/Windows) is running, or that the Docker service/daemon (on Linux) is active. Start Docker and try your Sail command again.

### 4. "Application key not set" Error

*   **Issue:** Your Laravel application shows an error page mentioning that the application key is missing.
*   **Solution:** The application key is essential for encryption. Generate it using Sail:
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

### 5. Database Connection Issues

*   **Issue:** Your application might show errors like "SQLSTATE[HY000] [2002] Connection refused" or "Access denied for user 'sail'@'...'".
*   **Solutions:**
    *   **Verify `.env` settings:** Double-check your database credentials in the `.env` file. For a default Sail setup, these are typically:
        *   `DB_CONNECTION=mysql` (or `pgsql` if you chose PostgreSQL)
        *   `DB_HOST=mysql` (This **must** be the Docker service name, not `localhost` or `127.0.0.1` for connections *from* your Laravel app *to* the DB container)
        *   `DB_PORT=3306` (or `5432` for PostgreSQL)
        *   `DB_DATABASE=your_database_name` (default is often `laravel`)
        *   `DB_USERNAME=sail`
        *   `DB_PASSWORD=password`
    *   **Sail Service Names:** Remember that within the Docker network, containers communicate using their service names (e.g., `mysql`, `redis`, `laravel.test`) as hostnames.
    *   **Restart Sail:** If you've made changes to `.env` or suspect an issue, try restarting Sail: `./vendor/bin/sail down && ./vendor/bin/sail up -d`.
    *   **Check Database Container Logs:** Use `./vendor/bin/sail logs mysql` (or your DB service name) to see if the database container started correctly and if there are any error messages.

### 6. General Sail Commands for Management

Here are some useful Sail commands for managing your Docker environment:

*   `./vendor/bin/sail up -d`: Starts all services in detached mode (background).
*   `./vendor/bin/sail down`: Stops all Sail-managed containers for the current project.
*   `./vendor/bin/sail down -v`: Stops containers AND removes their associated volumes (e.g., database data). **Use with caution, as this will delete your database data unless you have backups!**
*   `./vendor/bin/sail ps`: Shows the status of running Sail containers for the current project.
*   `./vendor/bin/sail logs <service-name>`: View real-time logs for a specific service.
    *   Example: `./vendor/bin/sail logs mysql`
    *   Example: `./vendor/bin/sail logs laravel.test`
*   `./vendor/bin/sail build --no-cache`: Forces a rebuild of your Docker images. Useful if you've changed a `Dockerfile` or suspect image corruption.
*   `./vendor/bin/sail restart`: A quick way to stop and then start all services.
*   `./vendor/bin/sail shell` or `./vendor/bin/sail bash`: Opens a shell session inside your main application container (`laravel.test`).
*   `./vendor/bin/sail artisan <command>`: Runs any Artisan command inside the application container (e.g., `./vendor/bin/sail artisan make:model Post`).
*   `./vendor/bin/sail composer <command>`: Runs any Composer command inside the application container.
*   `./vendor/bin/sail npm <command>` or `./vendor/bin/sail node <command>`: Runs NPM or Node commands.

### 7. VS Code Dev Container Issues

*   **Issue:** VS Code shows an error like "Dev container not starting," "Error attaching to container," or the window fails to connect to the dev container.
*   **Solutions:**
    *   **Ensure Docker is Running:** As with general Docker issues, make sure Docker Desktop or the Docker service is active.
    *   **Check Docker Logs:** Look at the logs from Docker Desktop or the Docker daemon for more detailed error messages.
    *   **Rebuild the Dev Container:**
        1.  Open the Command Palette in VS Code (`Ctrl+Shift+P` or `Cmd+Shift+P`).
        2.  Search for and select `Dev Containers: Rebuild Container`.
        3.  This will attempt to rebuild the dev container definition, which can resolve issues caused by outdated images or configuration problems.
    *   **Close Remote Connection and Retry:** Sometimes, simply closing the remote connection (File > Close Remote Connection) and then trying to "Reopen in Container" again can resolve temporary glitches.
    *   **Check `.devcontainer/devcontainer.json`:** If you have customized this file, ensure its syntax is correct.

Remember to check the official Laravel Sail documentation and the Docker documentation for more detailed troubleshooting information if you encounter issues not covered here.
