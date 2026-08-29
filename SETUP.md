# How to Run This Project on Another PC

This guide will walk you through the steps to set up and run this project on a new computer. The project consists of a Laravel backend and a separate frontend.

## Prerequisites

Before you begin, you need to install the following software on your new PC:

1.  **A local server environment:**
    *   For Windows, you can use [XAMPP](https://www.apachefriends.org/index.html) or [WAMP](https://www.wampserver.com/en/). These packages conveniently bundle Apache (web server), MariaDB/MySQL (database), and PHP.
2.  **[Composer](https://getcomposer.org/):**
    *   Composer is a dependency manager for PHP. You'll need it to install the Laravel project's dependencies.
3.  **[Git](https://git-scm.com/):**
    *   Git is a version control system used to manage the source code.

## Step 1: Get the Project Files

You can either copy the project files directly to the new PC or, if the project is in a Git repository, clone it.

```bash
# If you have a git repository, clone it
git clone <your-repository-url>
cd <project-directory>
```

## Step 2: Set Up the Laravel Backend

1.  **Navigate to the `laravel` directory:**
    ```bash
    cd laravel
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Create the environment file:**
    *   Copy the `.env.example` file to a new file named `.env`.
    ```bash
    copy .env.example .env
    ```

4.  **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure the database in the `.env` file:**
    *   Open the `.env` file in a text editor.
    *   Create a new database in your local server's database manager (e.g., phpMyAdmin if you are using XAMPP).
    *   Update the `DB_*` variables in your `.env` file to match your database configuration. For example:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=restaurant_system # Or whatever you named your database
    DB_USERNAME=root
    DB_PASSWORD= # Leave empty if you have no password, or enter your password
    ```

6.  **Run database migrations and seeders:**
    *   This will create the necessary tables and populate them with initial data.
    ```bash
    php artisan migrate --seed
    ```

7.  **Start the Laravel development server:**
    ```bash
    php artisan serve
    ```
    *   By default, the backend will be running at `http://127.0.0.1:8000`.

## Step 3: Configure and Run the Frontend

The frontend consists of static HTML, CSS, and JavaScript files.

1.  **Configure the API endpoint:**
    *   Open the `frontend/js/api.js` file.
    *   Make sure the `baseURL` variable points to your running Laravel backend.
    ```javascript
    const baseURL = 'http://127.0.0.1:8000/api';
    ```

2.  **Serve the frontend:**
    *   You can open the `.html` files from the `frontend/pages/` directory directly in your web browser.
    *   For a better experience, it's recommended to serve them through a local web server. If you are using XAMPP, you can place the `frontend` folder inside the `htdocs` directory and access it via `http://localhost/frontend/pages/login.html`.

After following these steps, the application should be up and running on your new PC.
