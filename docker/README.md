
docker build -t archetype-laravel .

docker run -d -p 9000:80 -v ${PWD}/.env.pre:/var/www/.env archetype-laravel:latest
