"# Mart24h"
When you clone a Laravel project from GitHub and it doesn't include the `.env` and `vendor` directories, you can follow these steps to set it up:

1. **Clone the Repository**:

   ```bash
   git clone <repository-url>
   cd <project-directory>
   ```
2. **Install Composer Dependencies**:
   Run the following command to install the necessary PHP packages:

   ```bash
   composer update
   ```
3. **Create the `.env` File**:
   Copy the example environment file and rename it to `.env`:

   ```bash
   cp .env.example .env
   ```
4. **Generate an Application Key**:
   Laravel requires an application key, which you can generate with:

   ```bash
   php artisan key:generate
   ```
5. **Set Up the Database**:
   Create a new database for your project and update the `.env` file with your database credentials:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
6. **Run Migrations**:
   Set up your database tables by running:

   ```bash
   php artisan migrate
   ```
7. **Start the Development Server**:
   Finally, start the Laravel development server:

   ```bash
   php artisan serve
   ```
8. **Fix storage if error**
   if Laravel storage:link not working follow this delete forlder storage let go to delete folder storage and install storage again
   **Command line Window**
   ```bash
   cd /path/to/laravel/project
   rmdir /s /q "C:\path\to\laravel\storage\logs"
   ```
   **Install Storage Laravel Project**
   ```bash
   php artisan storage:link
   ```
Following these steps should get your Laravel project up and running. If you encounter any issues, feel free to ask for more help!
