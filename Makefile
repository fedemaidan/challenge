run:
	docker run -p 9000:80 -d --name bluestart -v /home/fede/workspace/challenge/src:/var/www/html bluestart_image 

start:
	docker start bluestart

build:
	docker build -t bluestart_image .

test:
	docker exec -it challenge_bluestart_1 ./phpunit  --bootstrap autoload.inc.php  tests

exec-create:
	curl -X POST \
	http://localhost:9000/index.php/team \
	-H 'cache-control: no-cache' \
	-H 'content-type: multipart/form-data;' \
	-F name=newTeam

exec-get:
	curl -X GET \
  		http://localhost:9000/index.php/team \
  		-H 'cache-control: no-cache' \
  		-H 'content-type: multipart/form-data;'

exec-get-one:
	curl -X GET \
  		http://localhost:9000/index.php/team/5bdb3dec18443400110c42f2 \
  		-H 'cache-control: no-cache' \
  		-H 'content-type: multipart/form-data;'

exec-rename-player:
	curl -X PUT \
  		http://localhost:9000/index.php/player/95Mu3q \
  		-H 'cache-control: no-cache' \
  		-H 'content-type: multipart/form-data;'\
  		-F first_name=carlos


exec-put:
	curl -X PUT \
		 http://localhost:9000/index.php/team/5bdb3dec18443400110c42f2 \
		 -H 'cache-control: no-cache' \
		 -H 'content-type: multipart/form-data;'\
		 -F name=updatedTeam

exec-delete:
	curl -X DELETE \
		 http://localhost:9000/index.php/team/5bdb3dec18443400110c42f2 \
		 -H 'cache-control: no-cache' \
		 -H 'content-type: multipart/form-data; '