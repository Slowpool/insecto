FROM yiisoftware/yii2-php:7.4-apache

WORKDIR /app

RUN git clone https://github.com/Slowpool/insecto
RUN composer install
RUN chown -R www-data .