up:
	docker-compose up -d

build:
	docker-compose build

down:
	docker-compose down

node-build:
	docker build -t kvalue_node ./docker/node

node:
	docker run --rm -v $(PWD):/var/www/html -p 8888:8888 -it kvalue_node bash

php:
	docker exec -it kvalue_php_1 bash
