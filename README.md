# Car Catalogue Management System

This is a web application built with **Laravel 11** that allows users to manage a catalogue of cars. Users can view, add, edit, and delete cars from the catalogue. The application includes RESTful API endpoints for car management, validation of car attributes, and optional features such as image upload, user authentication, and pagination.

## Installation

### Prerequisites

- **PHP** >= 8.2
- **Composer**
- **MySQL** or **SQLite**
- **Laravel** 11.x

### Steps

1. **Clone the Repository**

   ```bash
   git clone https://github.com/kaynite/car-catalogue-management.git
   cd car-catalogue-management
   ```

2. **Install Dependencies**

   ```bash
   composer install
   ```

3. **Environment Setup**

   - Copy the `.env.example` file to `.env`:

     ```bash
     cp .env.example .env
     ```

   - Configure your database connection in the `.env` file.

     **For MySQL:**

     ```dotenv
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=car_catalogue
     DB_USERNAME=root
     DB_PASSWORD=
     ```

     **For SQLite:**

     ```dotenv
     DB_CONNECTION=sqlite
     DB_DATABASE=/absolute/path/to/database.sqlite
     ```

     *Note: For SQLite, ensure you create an empty `database.sqlite` file in your database directory.*

4. **Generate Application Key**

   ```bash
   php artisan key:generate
   ```

5. **Run Migrations**

   ```bash
   php artisan migrate
   ```

6. **Run the Development Server**

   ```bash
   php artisan serve
   ```

### Image Uploads

- Create a symbolic link from `public/storage` to `storage/app/public` to make the images accessible:

  ```bash
  php artisan storage:link
  ```

## Testing

You can run automated tests using PHPUnit:

```bash
php artisan test
```

## Decisions and Trade-offs

- **Database Choice**
  - **SQLite**: Chosen for simplicity and ease of setup, especially for testing and development environments.
  - **MySQL**: Supported for production environments where a robust database system is required.

- **Laravel Version**
  - Using **Laravel 11** to leverage the latest features and improvements.

- **Image Storage**
  - **Laravel Helpers**: I used Laravel's built-in helpers to save images directly to disk, as this provides a quick and straightforward solution for basic file handling.
  - **Laravel Media Library** (Recommended): For more robust and feature-rich file management, using a package like [Laravel Media Library](https://spatie.be/docs/laravel-medialibrary/) is preferable. It offers better control over file uploads, including handling multiple conversions, resizing, and associating files with models.

- **Code Structure**
  - **Controller-based Logic**: For this small project, all the business logic is placed within the controllers for simplicity.
  - **Service or Action Classes** (Recommended for Larger Projects): In larger applications, it’s better to separate business logic into service or action classes. This approach improves maintainability, testability, and adherence to SOLID principles.

- **Testing**
  - **Pest over PHPUnit**: I opted for Pest as the testing framework due to its elegance and simplicity compared to PHPUnit. Pest provides a more readable and expressive syntax, making tests easier to write and maintain.

- **Pagination**
  - Implemented to improve performance and user experience when dealing with large datasets.

## Setup Instructions Summary

1. Clone the repository and navigate to the project directory.
2. Install PHP and JavaScript dependencies using Composer and NPM.
3. Set up the environment variables in the `.env` file.
4. Generate the application key.
5. Run database migrations.
6. Start the development server.

## License

This project is open-source and available under the **MIT License**.
