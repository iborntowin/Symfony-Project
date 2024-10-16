To include a teaser image of your website directly in the README without specific instructions on how to add an image in the app, you can simply display the image under the **Screenshots** section. Here’s how you can do it:

---

# Symfony Web Application - Web 2.0 Class Project

This Symfony web application is developed as part of the Web 2.0 class, focusing on book and author management. The application allows users to add, edit, delete, and view authors and their books, providing a simple and intuitive interface.

## Table of Contents
- [Features](#features)
- [Screenshots](#screenshots)
- [Installation](#installation)
- [Usage](#usage)
- [Technologies Used](#technologies-used)
- [Contributing](#contributing)

## Features

- Add, edit, and delete authors with their profile pictures.
- Add, edit, and delete books with relevant details such as title, number of pages, and cover image.
- View detailed information for each author and their books.
- CSRF protection for form submissions.
- File upload functionality for images.

## Screenshots

Here’s a glimpse of the application:

![Main Page Screenshot](assets/images/1.png)

_Screenshot showing the main page of the application._

## Installation

Follow these steps to set up the project on your local machine:

### Prerequisites

Make sure you have the following installed:
- PHP 8.1 or higher
- Composer
- Symfony CLI
- MySQL (or another compatible database)

### Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/iborntowin/Symfony-Project.git
   ```
   
2. **Navigate to the project directory:**
   ```bash
   cd Symfony-Project
   ```

3. **Install dependencies:**
   ```bash
   composer install
   ```

4. **Set up your environment variables:**
   - Copy the `.env` file to `.env.local`:
     ```bash
     cp .env .env.local
     ```
   - Update the database credentials in the `.env.local` file:
     ```
     DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
     ```

5. **Create the database:**
   ```bash
   php bin/console doctrine:database:create
   ```

6. **Run migrations to set up the database schema:**
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

7. **Run the Symfony server:**
   ```bash
   symfony server:start
   ```
   The application should now be accessible at [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Usage

- Navigate to the home page to explore the features.
- You can add, edit, and delete authors and books from their respective sections.

## Technologies Used

- **Symfony**: PHP framework for building web applications.
- **Doctrine**: ORM (Object-Relational Mapping) library for database management.
- **Twig**: Templating engine used for rendering views.
- **Bootstrap**: CSS framework for responsive design.
- **MySQL**: Relational database for storing application data.

## Contributing

Feel free to fork this repository and make contributions. If you encounter any issues, please open a pull request or report a bug.

---
