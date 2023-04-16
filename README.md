# Fruit App

The Fruit App is a web application consisting of a Symfony backend API and a Vue.js frontend. The backend API provides
endpoints for managing fruits, while the frontend allows users to view and interact with the fruits.

## Setup environment

### Prerequisites

Before you begin, ensure that you have the following installed:

* Docker: https://docs.docker.com/engine/install/

## Installation

1. Clone the source repository:
   ```bash
   git clone https://github.com/faisal-ibrahim/symfony-vue-fruit-app.git
   ```
2. Navigate to the project directory:
   ```bash
    cd symfony-vue-fruit-app
   ```

3. Build and run the Docker containers:
    ```bash
			docker-compose up --build -d
    ```

4. Wait for the complete setup. You can check the status of whether all the containers are up and running via the
   following command:
   ```bash
   docker ps
    ```

## Fetching Fruits

To fetch fruits and insert them into the database, run the following commands:

1. Enter the PHP container:
   ```bash
   docker exec -it php-server /bin/bash
   ```
2. Inside the container, run the following command:

    ```bash
   bin/console app:fetch-fruits
   ```

## Access the backend API

The backend API will be running at the following URL: http://localhost:8081

### Endpoints

| Method | Endpoint             | Param                     | Comment                                       |
|--------|----------------------|---------------------------|-----------------------------------------------|
| GET    | `api/fruits`         | page, limit, name, family | List of fruit, filterable via name and family |
| GET    | `api/favorites`      |                           | List of favorite fruits                       ||
| POST   | `api/favorites/{id}` | fruit id as path param    | Add fruit as favorite                         |
| DELETE | `api/favorites/{id}` | fruit id as path param    | Remove fruit from favorite                    |

## Access to the Frontend Application

The frontend application will be running at the following URL: http://localhost:5173

## Testing

### Prerequisites

Before running the tests, ensure that you have completed the setup environment steps above.

## Installation

1. Setup the test Database (only first time)
   ```bash
			docker exec -it php-server /bin/bash
			bin/console --env=test doctrine:database:create
			bin/console --env=test doctrine:schema:create
			bin/console --env=test doctrine:fixtures:load
	```
2. Run the tests using PHPUnit:
   ```bash 
    ./vendor/bin/phpunit
   ```

