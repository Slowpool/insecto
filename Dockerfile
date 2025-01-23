# now this file is not used anywhere
FROM yiisoftware/yii2-php:8.3-fpm-nginx

RUN cd /app && composer update && chown -R www-data .