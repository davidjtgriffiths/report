## Installing Frontend Dependencies and Building Assets for `davidgriffiths/report`

The `davidgriffiths/report` project utilizes JavaScript (specifically Vue.js) and CSS (Tailwind CSS) for its frontend user interface, as indicated in its `README.md` and `package.json` file. These frontend dependencies are managed using Node Package Manager (NPM), and the assets (like CSS and JS files) must be compiled or "built" to be usable in the browser. Laravel Sail allows you to run all NPM commands directly within the Docker environment.

### 1. Install NPM Dependencies

The `package.json` file in the `davidgriffiths/report` project lists all the necessary JavaScript and CSS packages. To install these, navigate to your `report` project directory in the terminal and use the following Sail command:

```bash
./vendor/bin/sail npm install
```

This command instructs NPM (running inside the Sail container) to read the `package.json` and `package-lock.json` files and download the specified dependencies into a `node_modules` directory within your project.

### 2. Building Frontend Assets

Once the dependencies are installed, you need to compile your JavaScript and CSS. The `davidgriffiths/report` project uses Vite (as specified in its `package.json`) to bundle frontend assets. There are generally two types of builds:

*   **Development Build:** This build is optimized for development. Vite provides Hot Module Replacement (HMR), which automatically refreshes your browser or injects changes without a full page reload as you modify your Vue components or CSS. Source maps are also generated to make debugging in the browser easier.
*   **Production Build:** This build is optimized for deployment. Vite minifies the code, removes unused assets (tree-shaking), and generates smaller, more efficient files for users to download, improving load times.

#### For Development:

To compile your assets for development and start Vite's development server with HMR, run the following Sail command from your `report` project directory:

```bash
./vendor/bin/sail npm run dev
```

This command (which executes `vite` as per `package.json`) will watch your frontend files (typically in `resources/js` and `resources/css`) for changes and automatically recompile them. With HMR, your browser should reflect these changes almost instantly. You'll typically leave this command running in a separate terminal window while you are actively working on the frontend aspects of `davidgriffiths/report`.

#### For Production:

When you are ready to deploy `davidgriffiths/report` or want to test with assets as they would be in a production environment, you should generate a production build. Use the following Sail command:

```bash
./vendor/bin/sail npm run build
```

This command (which executes `vite build`) compiles and optimizes your assets for production. Vite will typically place these built assets into the `public/build` directory (or a similar location, as configured in `vite.config.js`). These are the static asset files that would be deployed to a production server. You generally run this command once as part of your deployment process.
