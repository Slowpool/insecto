# now this file is not used anywhere
FROM yiisoftware/yii2-php:8.3-fpm-nginx

# RUN cd /app && php yii migrate && y
RUN cd /app && php yii migrate --interactive=0