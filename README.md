# Launch Laravel Application using Docker
## Prerequisites

`Docker and Docker Compose should be installed on your machine.`

### Step 1: Clone the Laravel Application
##### `run terminal commands`
```sh 
git clone <repository_url>
cd <repository_name>
```
Replace <repository_url> with the URL of your Laravel application repository, and <repository_name> with the name of the cloned repository.

### Step 2: Build and Start Docker Containers
##### `run terminal command`
```sh
docker-compose up -d --build
```
### Step 3: Migration the Laravel Application
##### `run terminal commands`
```sh
docker ps
docker exec -it <container_name_or_id> php artisan migrate
```
Replace <container_name_or_id> with the name or ID of the Laravel container. Find the name or ID by running terminal command:

```sh
docker ps
```

### Step 5: Application is Launched

After executing the migration command, your Laravel application should be successfully launched and ready to use.
