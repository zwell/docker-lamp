FROM php:7.3-fpm
RUN docker-php-ext-install pdo_mysql
RUN groupadd www && useradd -g www -s /sbin/nologin www
RUN chown -R www:www /var
COPY php.ini /usr/local/etc/php/php.ini
COPY php-fpm.conf /usr/local/etc/php-fpm.conf
RUN docker-php-ext-install bcmath
#ADD composer.phar /usr/local/bin/composer
#RUN chmod 755 /usr/local/bin/composer