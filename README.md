(not tested)
to deploy this app you should follow the next steps:
1. go to app-php via `cd app-php`
2. rename `.env.example` to `.env` (and change some values as desired)
3. execute `composer update` to install dependencies (make sure dependencies are installed successfully. it's possible that you don't have required php installed on your host and you might get composer errors)
4. execute `docker compose up -d` to raise services
5. enter the app container via `docker exec -it php-app bash`
6. execute `chmod a+w -R /app` to allow www-data to work with files
7.  a) wait ~15 seconds.
    b) execute `php yii migrate` to you know. migrate db.
8. go to http://localhost:port/ , where `port` is `APP_PORT` you specified in .env
