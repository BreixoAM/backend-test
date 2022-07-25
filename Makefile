build:
	docker-compose build

up:
	docker-compose up --detach

composer:
	composer install

start: build up composer

down:
	docker-compose down

jump-in:
	docker exec -it php-backend-test /bin/bash

fix:
	docker exec -it php-backend-test vendor/bin/php-cs-fixer fix

stan:
	docker exec -it php-backend-test vendor/bin/phpstan analyse -l 9 src tests

unit:
	docker exec -it php-backend-test vendor/bin/phpunit

unit-coverage:
	docker exec -it php-backend-test vendor/bin/phpunit --coverage-html report

mutations:
	docker exec -it php-backend-test vendor/bin/infection

behat:
	docker exec -it php-backend-test vendor/bin/behat

tests: unit behat
