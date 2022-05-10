# Api test 2

### Instructions:
1. copy **app/.env.example** to **app/.env**
2. docker-compose up -d --build
3. bash composer install
4. bash artisan key:generate
5. bash artisan migrate

<hr>

### Commands:
**Run seeders:** bash artisan db:seed<br>
**Run tests:** bash artisan test<br>
**Generate api doc:** bash artisan l5-swagger:generate

http://localhost/ <br>
http://localhost/api/documentation
