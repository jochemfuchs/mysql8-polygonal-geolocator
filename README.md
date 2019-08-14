# mysql8-polygonal-geolocator

This Demo project is a companion to the blog post at https://medium.com/maatwebsite/mysql-8-polygonal-map-search-f3caeb614ffd

## Running the demo

I've provided a Docker setup to run this project. All you need is to copy docker-compose.yml.dist to docker-compose.yml, change whatever paths or settings you need changed and run `docker-compose up -d`.
You will then need to install the dependencies through yarn and composer, and run migrations. 

You can do all of this through docker:

`docker-compose exec fpm composer install`

`docker-compose exec node yarn install`

`docker-compose restart node`

Now you can access the demo at http://localhost:8080
