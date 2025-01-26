FROM yiisoftware/yii2-php:8.3-fpm-nginx

# TODO uncomment in production
# RUN export temp=${DB_PORT} && \
# # problem: php yii migrate 
# export DB_PORT=3306 && \
# cd /app && \
# php yii migrate --interactive=0 && \
# export DB_PORT=${temp}

# RUN cd /app && php yii migrate --interactive=0

# upd: turned out that xdebug works well even without this cfg.
# COPY xdebug.ini /usr/local/etc/php/conf.d/