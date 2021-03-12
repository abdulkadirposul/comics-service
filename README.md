# comics-service
This project is created to complete a code challenge of Seven Senders

# installation
please follow the steps mentioned below:
```
git clone https://github.com/abdulkadirposul/comics-service.git
cd comics-service
docker-compose up -d
docker-compose exec src cp .env.example .env -u
docker-compose exec src composer update
docker-compose exec src php artisan key:generate
```

# navigation
You can get more info via one of the following links
- <a href="http://127.0.0.1:8080">Homapage</a>
- <a href="http://127.0.0.1:8080/api/documentation">Swagger Documentation</a>
- <a href="http://127.0.0.1:8080/api/comics">Comics Service</a>