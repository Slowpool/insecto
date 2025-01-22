FROM yiisoftware/yii2-php:7.4-apache

# genius
# RUN git clone https://github.com/Slowpool/insecto /app

WORKDIR /app

RUN composer install
RUN chown -R www-data .