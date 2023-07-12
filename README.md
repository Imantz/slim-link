# Launch Laravel Application using Docker
## Prerequisites

Docker and Docker Compose, Composer should be installed on your machine.

### Step 1: Clone the Laravel Application
##### `run terminal commands`
```sh 
git clone <repository_url>
cd <repository_name>
composer install
```
Replace <repository_url> with the URL of your Laravel application repository, and <repository_name> with the name of the cloned repository.

### Step 2: Create .env file and copy .env.example content to .env file (must be both files to prevent error) 
##### `run terminal commands`
```sh
touch .env
cp .env.example .env
```
### Step 3: Build and Start Docker Containers
##### `run terminal command`
```sh
docker-compose up -d
```
### Step 4: Migration the Laravel Application
##### `run terminal commands`
```sh
docker ps
docker exec -it <container_name_or_id> php artisan migrate
```
Replace <container_name_or_id> with the name or ID of the Laravel container.

### Step 5: Application is Launched

After executing the migration command, your Laravel application should be successfully launched and ready to use.

```sh
    URL: http://localhost:8080/
```

## Valid Routes

GET request

    localhost:8080/shortUrl

    where shortUrl is the generated short URL 

POST request 
    
    localhost:8080/

    Post request body example:
        ​{"url":"https://laravel.com"}

    header:
        Content-Type: application/json


