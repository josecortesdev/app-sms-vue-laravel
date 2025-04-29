# SMS Application

This project is a basic template for an application that allows sending SMS, managing a message history, and performing other related functionalities. It is built with **Vue.js** for the frontend and **Laravel** as a RESTful API backend, styled with **Bootstrap**.

## Features

- **RESTful API**: Built with Laravel to handle SMS sending, message history, and other backend functionalities.
- **Frontend with Vue.js**: A dynamic and responsive user interface for interacting with the API.
- **Bootstrap Styling**: Pre-configured with Bootstrap for a clean and modern design.
- **SOLID Principles**: The backend is designed following SOLID principles, allowing flexibility and scalability.
- **Service Switching**: Easily switch between SMS providers (e.g., Altiria or Twilio) using an interface-based implementation.
- Ready-to-use template for customization and extension.
- Initial setup for Laravel and Vite.

## Prerequisites

Make sure you have the following programs installed:

- [Node.js](https://nodejs.org/) (version 16 or higher)
- [Composer](https://getcomposer.org/)
- [PHP](https://www.php.net/) (version 8.1 or higher)
- [Laravel](https://laravel.com/)

## Installation

1. Clone this repository:

   ```bash
   git clone <REPOSITORY_URL>
   cd app-sms
   ```

2. Install PHP dependencies using Composer:

   ```bash
   composer install
   ```

3. Install Node.js dependencies:

   ```bash
   npm install
   ```

4. Configure the `.env` file:

   Copy the `.env.example` file and rename it to `.env`. Then, configure the necessary variables, such as the database connection and SMS provider credentials.

   ```bash
   cp .env.example .env
   ```

5. Generate the Laravel application key:

   ```bash
   php artisan key:generate
   ```

6. Run the database migrations (if applicable):

   ```bash
   php artisan migrate
   ```

7. Start the development server:

   ```bash
   php artisan serve
   npm run dev
   ```

   The application will be available at:
   - Backend (API): `http://localhost:8000`
   - Frontend: `http://localhost:5173`

## Project Structure

### Backend (Laravel API)
The Laravel backend serves as a RESTful API to handle the following functionalities:
- **Send SMS**: Endpoints to send SMS to specific phone numbers.
- **Message History**: Endpoints to retrieve the history of sent messages.
- **Service Switching**: The backend uses an interface to abstract SMS services, allowing you to switch between providers like Altiria and Twilio without modifying the core logic.

Key files:
- **routes/api.php**: Defines the API routes.
- **app/Http/Controllers**: Contains the controllers for handling API requests.
- **app/Services/SMSServiceInterface.php**: Defines the interface for SMS services.
- **app/Services/AltiriaService.php**: Implementation of the SMS service using Altiria.
- **app/Services/TwilioService.php**: Implementation of the SMS service using Twilio.

### Frontend (Vue.js)
The Vue.js frontend provides a user interface to interact with the API:
- **SMS Form**: A form to send SMS to specific phone numbers.
- **Message History**: A page to display the history of sent messages.
- **Dynamic Components**: Built with reusable Vue components.

Key files:
- **resources/js/components**: Vue.js components.
- **resources/js/app.js**: Main entry point for the frontend.
- **resources/css/app.css**: Main project styles.

## Customization

You can customize this template according to your needs. For example:
- Add new API endpoints in Laravel.
- Extend the Vue.js frontend with additional components or pages.
- Change the design using Bootstrap or any other CSS framework.
- Add new SMS providers by implementing the `SMSServiceInterface`.


## Notes

This template is a starting point for building an SMS application. While the full code and advanced features will remain private, I will showcase the functionalities and progress of this project on my LinkedIn profile. Stay tuned for updates and insights into how this project evolves!