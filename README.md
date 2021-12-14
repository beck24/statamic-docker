## Installation

1. Copy `.env.example` to `.env` set any required values.  For local dev with stock Statamic no changes are required

2. Optional: Copy your private ssh key to `.docker/config/ssh/id_rsa` - this will be installed into the container.  Useful for git usage in the container during development.

3. Build the container

        docker compose up -d --build

4. Log into the webserver container:

        docker exec -it statamic_webserver bash

    Files are located at `/var/www/html/`

5. Install Dependencies and instantiate Laravel

        composer install

        php artisan key:generate
        php artisan storage:link
        php artisan cache:clear

    Make sure directories are writable (Note: don't use 777 on prod, dev only for simplicity)

        chmod -R 777 storage/ resources/users/ content/

6. Ccreate a new user

        php please make:user

7. Log into the control panel at http://localhost/cp
