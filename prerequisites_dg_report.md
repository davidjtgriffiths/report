## Prerequisites

Before you begin setting up the `davidgriffiths/report` project using Docker and Sail, ensure you have the following software installed on your system:

*   **Git:** A version control system essential for cloning the repository and managing code changes. You can download it from [https://git-scm.com/downloads](https://git-scm.com/downloads).
*   **Docker Desktop:** This tool simplifies the setup and management of Docker environments on Mac and Windows. It includes Docker Engine, Docker CLI, and Docker Compose. Download it from [https://www.docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop).
    *   **For Linux Users:** You will need to install Docker Engine and Docker Compose separately.
        *   Install Docker Engine: [https://docs.docker.com/engine/install/](https://docs.docker.com/engine/install/) (Choose your distribution for specific instructions).
        *   Install Docker Compose: [https://docs.docker.com/compose/install/](https://docs.docker.com/compose/install/) (Follow the "Install Compose Standalone" guide).
*   **Visual Studio Code (VS Code):** A lightweight yet powerful source code editor that is highly recommended for this tutorial due to its excellent Docker integration. Download it from [https://code.visualstudio.com/download](https://code.visualstudio.com/download).
*   **VS Code 'Remote - Containers' Extension:** This extension is crucial for working with Dockerized applications in VS Code. It allows you to open your project folder inside (or mounted into) a Docker container and leverage VS Code's full feature set as if you were developing locally, but within the container's isolated environment. You can install it directly from the VS Code Marketplace.
*   **Recommended VS Code Extensions for Laravel & Vue.js Development:**
    *   **PHP Intelephense:** Provides advanced PHP IntelliSense, code completion, and diagnostics for Laravel development.
    *   **Laravel Extension Pack:** A collection of popular VS Code extensions specifically for Laravel development, often including tools for Blade, Artisan, and more.
    *   **Volar (Vue Language Features):** The official Vue.js language support extension, providing features like syntax highlighting, TypeScript support, and template type checking for Vue 3. (Formerly known as VueDX, this is the current recommendation).
    *   **Prettier - Code formatter:** An opinionated code formatter that supports many languages, including PHP, JavaScript, and Vue. It helps maintain a consistent code style across your project.
    *   **Tailwind CSS IntelliSense (if applicable):** If the project uses Tailwind CSS (common with Laravel and Vue.js setups), this extension provides autocompletion, linting, and hover previews for Tailwind classes. (The `README.md` mentions Tailwind CSS).
