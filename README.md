## Installation

Standard Laravel installation

Make sure the following directories are writable by the server.

`/storage/`
`/resources/users/`
`/content/`


## Development

Copy `.env.example` to `.env` set any required values

Copy your private key to `.docker/config/ssh/id_rsa` - this will be installed into the container

Build the container

    docker compose up -d --build

Use VSCode with Remote Explorer to edit the files inside the container.  Use git to commit/push/pull new code inside of the container.

Log into the webserver container:

    docker exec -it nebraska_gap_webserver bash

Files are located at `/var/www/html/`

Install Dependencies and instantiate Laravel

    composer install

    php artisan key:generate
    php artisan storage:link
    php artisan cache:clear

Make sure directories are writable (Note: don't use 777 on prod, dev only for simplicity)

    chmod -R 777 storage/ resources/users/ content/

If you need to create a new user at this point

    php please make:user

Build js/css - this is configured to use tailwindcss and will strip out unused styles from the prod css

    npm install

    npm run watch (or npm run dev, or npm run prod)

Log into the control panel at http://localhost/cp

## Docker Containers

- Webserver - contains the laravel/statamic files

Log into the container

    docker exec -it nebraska_gap_webserver bash

