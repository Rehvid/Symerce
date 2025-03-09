# Load variables from .env
include docker/.env
export $(shell sed -n 's/=.*//p' docker/.env)

# Variables
DOCKER_COMPOSE = docker-compose -f docker/docker-compose.yml

print-env:
	@cat docker/.env

start:
	$(DOCKER_COMPOSE) -p $(PROJECT_NAME) up -d

build:
	$(DOCKER_COMPOSE) -p $(PROJECT_NAME) build

down:
	$(DOCKER_COMPOSE) -p $(PROJECT_NAME) down

remove:
	$(DOCKER_COMPOSE) -p $(PROJECT_NAME) rm -f

logs:
	$(DOCKER_COMPOSE) -p $(PROJECT_NAME) logs -f

ps:
	docker ps --format "table {{.ID}}\t{{.Names}}\t{{.Status}}\t{{.Ports}}"

bash:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash

create-migration:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "php bin/console make:migration"

composer-install:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "composer install"

npm-install:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "npm install"

node-npm-version:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "node -v && npm -v"

npm-watch:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "npm run watch"

npm-build:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "npm run build"

# PHP Tools
phpstan:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "vendor/bin/phpstan analyse"

phpmd:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "vendor/bin/phpmd src/ text phpmd.ruleset.xml"

phpcsfixer:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "vendor/bin/php-cs-fixer fix src"

phpunit:
	cd docker && docker exec -it $(PHP_CONTAINER_NAME) bash -c "vendor/bin/phpunit"

