
## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Run Locally
Clone the repository and go to {application directory} directory

*git clone https://github.com/{username}/{repository name}.git

*cd {application directory}
*Generate .env file

*cp .env.example .env
Then, configure the .env file according to your use case.

Install the dependencies
*composer install

Populate the tables to the database
*php artisan migrate

Seed data to the dabase
*php aritsan db:seed

Generate app key
*php artisan key:generate

Run the application
*php artisan serve

## Admin Credentials
email: admin@gmail.com
password: admin12345


### User Credentials
email: user@gmail.com
password: user12345


