to deploy this app you should follow the next steps:
1. go to app-php via `cd app-php`
2. rename `.env.example` to `.env` (and change some values as desired)
3. execute `composer update` to install dependencies (make sure dependencies are installed successfully. it's possible that you don't have required php installed on your host and you might get composer errors)
4. (linux only) execute `chmod a+w -R .` to allow www-data to work with files
5. execute `docker compose up -d` to raise services
6. go to http://localhost:*APP_PORT from .env*/
