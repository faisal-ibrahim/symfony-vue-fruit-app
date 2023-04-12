# Fruit App
## Setup environment
#### Install docker (If you don't have docker installed already)
Follow the link
https://docs.docker.com/engine/install/
#### Clone source repository
	git clone https://github.com/faisal-ibrahim/symfony-vue-fruit-app.git
#### Go to the project directory
	cd symfony-vue-fruit-app
#### Build and run docker
	docker-compose up --build -d
#### Wait for the complete setup. You can check the status of whether all the containers are up and running via the following command
	docker ps
## To fetch fruits run the following commands

This command will let you enter the PHP container

	docker exec -it php-server /bin/bash

Inside the container, type the following command to fetch fruits and insert them into the database.
	
	bin/console app:fetch-fruits
## Access the backend API
#### The api will be running at the following URL

http://localhost:8081

#### Endpoints
|Method|Endpoint|Param|Comment|
|--|--|--|--|
|GET|`api/fruit`|page, limit, name, family| List of fruit, filterable via name and family|
|GET|`api/favorite`||List of favorite fruits||
|POST|`api/favorite/{id}`|fruit id as path param|Add fruit as favorite|
|DELETE|`api/favorite/{id}`|fruit id as path param|Remove fruit from favorite|

## Access Frontend Application

http://localhost:8082