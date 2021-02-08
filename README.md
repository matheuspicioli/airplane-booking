# Configurations
The application use docker/docker-compose to run an development environment.

Create the `.env` on root project folder. The only requirement is have `db` value
on `DB_HOST` variable. This represent the `db` service, especified on the `docker-compose.yml`.
And run `docker-compose exec app composer install`

#Run
On the root folder:
* `docker-compose up -d` Wait a feel seconds and execute the next command
* `docker-compose exec app php artisan migrate --seed`

# Tests
* `docker-compose exec app php artisan test`
