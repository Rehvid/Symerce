# Load variables from .env
include docker/.env
export $(shell sed -n 's/=.*//p' docker/.env)

# Variables
DOCKER_COMPOSE = docker-compose -f docker/docker-compose.yml

print-env:
	@cat docker/.env

init:
	$(MAKE) start
	$(MAKE) composer-install
	$(MAKE) migrate
	$(MAKE) bootstrap-fixtures

start:
	$(DOCKER_COMPOSE) -p $(PROJECT_NAME) up -d

up:
	$(DOCKER_COMPOSE) up -d

build:
	$(DOCKER_COMPOSE) -p $(PROJECT_NAME) build

down:
	$(DOCKER_COMPOSE) down

restart:
	$(DOCKER_COMPOSE) restart

remove:
	$(DOCKER_COMPOSE) -p $(PROJECT_NAME) rm -f

logs:
	$(DOCKER_COMPOSE) -p $(PROJECT_NAME) logs -f

ps:
	docker ps --format "table {{.ID}}\t{{.Names}}\t{{.Status}}\t{{.Ports}}"

bash:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash

cache-clear:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "php bin/console cache:clear"

create-migration:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "php bin/console make:migration"

migrate:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "php bin/console doctrine:migrations:migrate"

schema-update-force:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "php bin/console doctrine:schema:update --force"

composer-install:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "composer install"

bootstrap-fixtures:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "php bin/console doctrine:fixtures:load --group=bootstrap --append"

fake-data-fixtures:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "php bin/console doctrine:fixtures:load --group=fakeData --append"

npm-install:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "npm install"

node-npm-version:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "node -v && npm -v"

npm-build-all:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "npm run build:all"

npm-build-admin:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "npm run build:admin"

npm-build-shop:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "npm run build:shop"

npm-watch-all:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "npm run watch:all"

npm-watch-admin:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "npm run watch:admin"

npm-watch-shop:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "npm run watch:shop"


# PHP Tools
phpstan:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "vendor/bin/phpstan analyse src/"

phpmd:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "vendor/bin/phpmd src/ text phpmd.ruleset.xml"

phpmd-debug:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "vendor/bin/phpmd src/ text phpmd.ruleset.xml --verbose"

phpcsfixer:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "vendor/bin/php-cs-fixer fix src"

phpunit:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "vendor/bin/phpunit"

# Js TOOLS
prettier-format:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "npm run prettier-format"

check-eslint:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "npx eslint assets --ext .js,.jsx --no-error-on-unmatched-pattern"

fix-eslint:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "npx eslint assets --ext .js,.jsx --fix"
