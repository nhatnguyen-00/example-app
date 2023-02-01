sh:
	- docker-compose exec laravel.test sh
start:
	- docker-compose up -d
down:
	- docker-compose down
connect-php:
	- docker-compose run php sh
route-list:
	- docker-compose run php php artisan route:list
