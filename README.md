# Challenge

## Requirements

 - docker
 - docker-compose

## Run

1. Configure .env file
2. Run:
    
        docker-compose build		

Open http://localhost:3000/frontend

## Tests
    docker exec -it challenge_backend_1 ./phpunit  --bootstrap autoload.inc.php  tests

## Develop

It has 3 components:

 1. Backend
 2. Frontend
 3. DB -> It is a MongoDB

### Backend and DB

    docker-compose up -d

Code all what you want in backend folder

Endpoints:

1. /index.php/team 		[POST, GET, PUT, DELETE]

2. /index.php/player	[PUT]

### Frontend

Requiere to install angular-cli

Start backend and go to frontend folder to exec:

    ng serve

Open http://localhost:4200

Code all what you want in frontend folder