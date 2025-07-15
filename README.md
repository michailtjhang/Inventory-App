# Inventory-App

Inventory-App is a web-based inventory management system built with Laravel, Inertia.js, and Vue 3. This application helps you track inventory items, manage stock movements, and monitor inventory levels through an intuitive interface designed for modern web workflows.

## Requirements

<a href="https://laravel.com/docs/11.x/releases"><img src="https://img.shields.io/badge/Laravel-v11-blue" alt="Laravel Version"></a> <a href="https://www.php.net/releases/8.2/en.php"><img src="https://img.shields.io/badge/PHP-v8.2.4-blue" alt="PHP Version"></a> <a href="https://getcomposer.org/"><img src="https://img.shields.io/badge/Composer-v2.6.5-brown" alt="Composer Version"></a> <a href="https://www.mysql.com/"><img src="https://img.shields.io/badge/MySQL-v8.0-orange" alt="MySQL"></a> <a href="https://inertiajs.com/"><img src="https://img.shields.io/badge/Inertia.js-v1-green" alt="Inertia.js"></a> <a href="https://vuejs.org/"><img src="https://img.shields.io/badge/Vue-3.x-brightgreen" alt="Vue 3"></a> <a href="https://nodejs.org/"><img src="https://img.shields.io/badge/Node.js-v18.x-lightgrey" alt="Node.js"></a> <a href="https://www.npmjs.com/"><img src="https://img.shields.io/badge/NPM-v9.x-red" alt="NPM"></a>

## Installation

* Download the ZIP file: <a href="https://github.com/michailtjhang/Inventory-App/archive/refs/heads/main.zip">Click here</a>
* Or clone the repository via terminal:

  ```bash
  git clone https://github.com/michailtjhang/Inventory-App.git
  ```

## Setup

1. Open your terminal and go to the project directory.
2. Copy the example environment file:

   ```bash
   cp .env.example .env
   ```
3. Install PHP dependencies:

   ```bash
   composer install
   ```
4. Install JavaScript dependencies:

   ```bash
   npm install
   ```
5. Generate the application key:

   ```bash
   php artisan key:generate
   ```

### Configure the Database

1. Create a new MySQL database.
2. Update the `.env` file with your database credentials.
3. Run database migrations:

   ```bash
   php artisan migrate
   ```
4. (Optional) Seed the database:

   ```bash
   php artisan db:seed
   ```

### Run the Application

1. Start the Laravel backend server:

   ```bash
   php artisan serve
   ```
2. Start the Vite development server for the Vue frontend:

   ```bash
   npm run dev
   ```

## Features

### Core Features

* **Item Management**: Add, update, and delete inventory items with details like name, code, category, and quantity.
* **Stock In & Out**: Track incoming and outgoing stock with transaction history.
* **Category Management**: Organize items by categories for easy filtering and reporting.
* **User Roles**: Manage access for admins and staff.
* **Dashboard & Statistics**: Get an overview of stock levels and recent transactions.
* **Search & Filter**: Quickly find items or transactions.
* **Responsive UI**: Optimized for both desktop and mobile with Vue 3.

### Additional Features

* **Notifications**: Low stock alerts (if enabled).
* **Export Data**: Export inventory data to CSV/Excel (optional).
* **Activity Log**: Track important actions within the app (optional).

### Non-Functional Requirements

* **Security**: Follows Laravel 11 security best practices for authentication and authorization.
* **Performance**: Uses Inertia.js for seamless navigation and improved user experience.
* **Accessibility**: Built with modern frontend standards for usability.

## Accounts & Access

* Default roles: Admin and Staff. You can add or manage users through the user management page after installation.

## Contribution

Feedback and contributions are welcome! Please open an issue or submit a pull request if you want to help improve the project.

## Author

**Project by Michail Tjhang**
[https://github.com/michailtjhang](https://github.com/michailtjhang)
