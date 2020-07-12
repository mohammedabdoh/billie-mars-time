DOCKER=docker run -u root --rm

COMPOSER_DOCKER_IMAGE=composer

COMPOSER=$(DOCKER) --user $(id -u):$(id -g) -v ${PWD}:/app $(COMPOSER_DOCKER_IMAGE)

.PHONY: install
install: ## Install project dependencies
	@$(COMPOSER) composer install
	@$(COMPOSER) composer dump-autoload

.PHONY: run
run: ## run the application
	@docker-compose up --build -d
	@docker exec -it billie_php_fpm_container ./bin/console cache:warmup
	@printf "\n-> Service is available at: http://localhost"
	@printf "\n-> Example: http://localhost/mars-time/convert/2020-07-11T16:36:52+00:00\n"

.PHONY: test
test: ## run unit and functional tests
	@docker exec -it billie_php_fpm_container ./vendor/phpunit/phpunit/phpunit

.PHONY: api-docs
api-docs: ## open the api docs
	@open http://localhost/docs/

.PHONY: clean
clean: ## stops the containers if exists and remove all the dependencies
	@docker-compose down --remove-orphans || true

.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help
