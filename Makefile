start:
	docker-compose up -d

build:
	docker-compose build

test:
	docker exec -it challenge_backend_1 ./phpunit  --bootstrap autoload.inc.php  tests

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
  		http://localhost:9000/index.php/team/5bdc12a718443400180ea934 \
  		-H 'cache-control: no-cache' \
  		-H 'content-type: multipart/form-data;'

exec-rename-player:
	curl -X PUT \
  		http://localhost:9000/index.php/player/1hc4Bf \
  		-H 'cache-control: no-cache' \
  		-H 'content-type: multipart/form-data;'\
  		-F agility=100

exec-rename-team:
	curl -X POST \
		 http://localhost:9000/index.php/team/5bdc12a718443400180ea934 \
		 -H 'cache-control: no-cache' \
		 -H 'content-type: multipart/form-data;'\
		 -F name=newName

exec-delete:
	curl -X DELETE \
		 http://localhost:9000/index.php/team/5bdb3d121844340012391931 \
		 -H 'cache-control: no-cache' \
		 -H 'content-type: multipart/form-data; '