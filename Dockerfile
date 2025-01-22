FROM yiisoftware/yii2-php:7.4-apache

WORKDIR /app

RUN composer update
RUN chown -R www-data .