DOCKER=docker run -u root --rm

COMPOSER_DOCKER_IMAGE=composer

COMPOSER=$(DOCKER) --user $(id -u):$(id -g) -v ${PWD}:/app $(COMPOSER_DOCKER_IMAGE)

.PHONY: install
install: ## Install project dependencies
	@$(COMPOSER) composer install
	@$(COMPOSER) composer dump-autoload

.PHONY: web-shell
web-shell: ## Open the shell of the web container
	@docker exec -it web_container bash

.PHONY: code-std
code-std: ## Standardize the PHP code according to PSR2
	@docker exec -it web_container ./vendor/bin/phpcbf

.PHONY: code-chk
code-chk: ## Check the PHP code according to PSR2
	@docker exec -it web_container ./vendor/bin/phpcs

.PHONY: safe-chk
safe-chk: ## Check if dependencies are safe
	@docker exec -it web_container ./bin/console security:check

.PHONY: run
run: ## run the application
	@sudo chmod -R 777 ./docker/socket
	@docker-compose up --build -d

.PHONY: clean
clean: ## stops the containers if exists and remove all the dependencies
	@docker-compose down --remove-orphans || true
	@sudo rm -rf vendor || true
	@sudo rm -rf var/cache/* || true
	@sudo rm -rf bin/.phpunit || true
	@sudo rm -rf composer.lock || true

.PHONY: api-docs
api-docs: ## Show the API documentation
	@open http://localhost/docs/

.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help
