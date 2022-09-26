### Common way

Rename the .env.example file to .env, and change APP_URL and MIX_APP_URL in .env file to your local domain, then:

Install PHP and JavaScript dependencies:

    composer install
    npm install

Generate Laravel keys:

    php artisan key:generate

Migrate and seed the database:

    php artisan migrate --seed

Compile all the front-end stuff:

    npm run dev

Account Default:

    user: admin@admin.com
    password: 123456
