default: help

help:
	@echo "Available make commands:\n"; \
	echo  "Docker related:"; \
	echo  "\033[0;32mup\033[0m                    Boots containers (shortcut for docker-compose up)"; \
	echo  "\033[0;32mdown\033[0m                  Shuts down containers (shortcut for docker-compose down)"; \
	echo  "\033[0;32mreload\033[0m                Runs down + up"; \
	echo  "\nSSH shortcuts:"; \
	echo  "\033[0;32mgo-cassandra\033[0m          Enters fuseki"; \
	echo  "\nDebug:"; \
	echo  "\033[0;32mlogs\033[0m                  Shows logs (all containers)"; \
	echo  "";

up:
	@docker-compose up -d; \
	echo "\nFuseki is running"; \
	echo "\n";


down:
	@docker-compose down --remove-orphans

reload: down up

ps:
	@docker-compose ps

go-fuseki:
	@docker exec -it jena_fuseki bash

logs:
	@docker-compose logs


