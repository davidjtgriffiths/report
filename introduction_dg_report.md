## Introduction to the Tutorial for `davidgriffiths/report`

This tutorial will guide you through setting up the `davidgriffiths/report` project (assumed to be available at `https://github.com/davidgriffiths/report.git`) on your local machine for development.

The `davidgriffiths/report` application is a Laravel project that utilizes Vue.js and Inertia.js for its frontend, as outlined in the project's `README.md`.

For a consistent, isolated, and easy-to-manage development environment, this tutorial will focus on using Docker and Laravel Sail. Laravel Sail is a light-weight command-line interface for interacting with Laravel's default Docker development environment and is typically included as a dependency in the `composer.json` file of modern Laravel projects, making it an excellent choice for this application.

The project's `README.md` already provides a general "Project Setup" guide. This tutorial complements those instructions by specifically detailing a Dockerized approach using Sail. The key advantage of using Sail is that it manages PHP, Node.js, Composer, and other dependencies within Docker containers. This approach can significantly simplify the setup process across different developer machines and operating systems by avoiding the need to install and manage these dependencies directly on your local system.

We recommend using Visual Studio Code (VS Code) as your code editor. Its 'Remote - Containers' extension offers seamless integration with the Dockerized environment provided by Sail, allowing you to develop directly inside the container with full access to language features, debugging, and the terminal.
