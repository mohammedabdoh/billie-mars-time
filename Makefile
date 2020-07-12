DOCKER=docker run -u root --rm

COMPOSER_DOCKER_IMAGE=composer

COMPOSER=$(DOCKER) --user $(id -u):$(id -g) -v ${PWD}:/app $(COMPOSER_DOCKER_IMAGE)

.PHONY: install
install: ## Install project dependencies
	@$(COMPOSER) composer install
	@$(COMPOSER) composer dump-autoload

.PHONY: run
run: ## run the application
	@chmod -R 777 ./docker/socket
	@docker-compose up --build -d
	@chmod -R 777 ./var/cache
	@docker exec -it billie_php_fpm_container ./bin/console cache:warmup

.PHONY: test
test: ## run unit and functional tests
	@docker exec -it billie_php_fpm_container ./vendor/phpunit/phpunit/phpunit

.PHONY: clean
clean: ## stops the containers if exists and remove all the dependencies
	@docker-compose down --remove-orphans || true
	@sudo rm -rf vendor || true
	@rm -rf composer.lock || true

.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help
