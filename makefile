composerFile := -f docker/docker-compose.yml
image := mail_php
network := mail_network

up:
	docker-compose $(composerFile) up -d

down:
	docker-compose $(composerFile) down

install:
	docker-compose $(composerFile) exec $(image) bash -c "composer install && php yii rabbitmq/declare-all "

init:
	make up
	sleep 10
	make install