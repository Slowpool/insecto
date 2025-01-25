to deploy this app you should follow the next steps:
1. rename `.env.example` to `.env` (and change some values as desired)
2. execute (being in the root dir of repository) `cd app-php && composer install && sudo chgrp www-data . && sudo chmod g+w -R .`  to install dependencies (make sure dependencies are installed successfully. it's possible that you don't have required php installed on your host and you might get composer errors) and to give rights to www-data
3. execute `docker compose up -d` to raise services
4. go to http://localhost:*APP_PORT from .env*/

