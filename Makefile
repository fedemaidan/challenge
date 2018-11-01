run:
	docker run -p 9000:80 -d --name bluestart -v /home/fede/workspace/challenge/src:/var/www/html bluestart_image 

start:
	docker start bluestart

build:
	docker build -t bluestart_image .

test:
	docker exec -it bluestart ./phpunit  --bootstrap autoload.inc.php  tests
