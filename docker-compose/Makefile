.PHONY: help up realup install down ps go-mysql go-charlie logs
default: help

help:
	@echo "Available make commands:\n"; \
	echo  "Docker related:"; \
	echo  "\033[0;32mbuild\033[0m                 Builds images (shortcut for docker-compose build)"; \
	echo  "\033[0;32mup\033[0m                    Boots containers (shortcut for docker-compose up)"; \
	echo  "\033[0;32mdown\033[0m                  Shuts down containers (shortcut for docker-compose down)"; \
	echo  "\033[0;32mreload\033[0m                Runs down + up"; \
	echo  "\nSSH shortcuts:"; \
	echo  "\033[0;32mgo-cassandra\033[0m          Enters fuseki"; \
	echo  "\nDebug:"; \
	echo  "\033[0;32mlogs\033[0m                  Shows logs (all containers)"; \
	echo  "";

build:
	@docker-compose build

install:
	docker-compose exec semantic_project composer install;
	#docker-compose exec semantic_project php bin/console d:m:m --no-interaction; \
	#docker-compose exec semantic_project php bin/console d:f:l --no-interaction

up:
	@docker-compose up -d; \
	echo "\nFuseki is running"; \
	echo "\nWebsite is running at http://localhost:4010/"; \
	echo "\n";


down:
	@docker-compose down --remove-orphans

reload: down up

ps:
	@docker-compose ps

go-fuseki:
	@docker exec -it jena_fuseki bash

go-project:
	@docker exec -it semantic_project bash

logs:
	@docker-compose logs


