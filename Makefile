migrations-init:
	docker-compose run --rm api-php-cli php bin/console doctrine:migrations:migrate --no-interaction

fixtures-init:
	docker-compose run --rm api-php-cli php bin/console doctrine:fixtures:load --no-interaction

score-init:
	docker-compose run --rm api-php-cli php bin/console app:calculate-score

test-run:
	docker-compose run --rm api-php-cli php bin/phpunit
