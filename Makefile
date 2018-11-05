start:
	docker-compose up -d

build:
	docker-compose build

test:
	docker exec -it challenge_backend_1 ./phpunit  --bootstrap autoload.inc.php  tests
