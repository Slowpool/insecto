(not tested)
to deploy this app you should follow the next steps:
1. go to app-php via `cd app-php`
2. rename `.env.example` to `.env` (and change some values as desired)
3. execute `composer update` to install dependencies (make sure dependencies are installed successfully. it's possible that you don't have required php installed on your host and you might get composer errors)
4. execute `docker compose up -d` to raise services
5. execute `docker exec php-app chmod a+w -R /app` to allow www-data to work with files
6. execute `docker exec php-app php yii migrate --interactive=0` to you know. migrate db.
7. go to http://localhost:port/ , where `port` is `APP_PORT` you specified in .env