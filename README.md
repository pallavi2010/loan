
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
Clone the repository and go to {application directory} directory<br>

*git clone https://github.com/{username}/{repository name}.git<br>

*cd {application directory}<br>
*Generate .env file<br><br>

*cp .env.example .env<br>
Then, configure the .env file according to your use case.<br><br>

Install the dependencies<br>
*composer install<br><br>

Populate the tables to the database<br>
*php artisan migrate<br><br>

Seed data to the dabase<br>
*php aritsan db:seed<br><br>

Generate app key<br>
*php artisan key:generate<br><br>

Run the application<br>
*php artisan serve<br><br>

## Admin Credentials
email: admin@gmail.com<br>
password: admin12345<br><br>


### User Credentials
email: user@gmail.com<br>
password: user12345<br><br>


