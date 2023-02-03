## Setup
- install docker and docker-compose on your machine
- install composer dependencies: `docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs`
- run `cp .env.example .env`
- start docker: `docker-compose up -d`
- sh to container php: `docker-compose exec laravel.test sh`
- run: `php artisan migrate --seed`
