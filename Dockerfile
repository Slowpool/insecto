FROM yiisoftware/yii2-php:7.4-apache

WORKDIR /app
COPY . .

RUN composer update
RUN chown -R www-data .