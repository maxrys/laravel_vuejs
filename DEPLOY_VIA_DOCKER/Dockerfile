
FROM alpine:3.18

# Setup document root
WORKDIR /var/www/html

# Install packages
RUN apk add --no-cache \
    bash \
    supervisor \
    openssl \
    curl \
    git \
    nginx \
    php81 \
    php81-fpm \
    php81-curl \
    php81-iconv \
    php81-mbstring \
    php81-openssl \
    php81-pdo \
    php81-pdo_sqlite \
    php81-zip \
    php81-phar \
    php81-session \
    php81-tokenizer \
    php81-xml \
    php81-xmlwriter \
    php81-dom \
    php81-fileinfo \
    composer \
    npm

RUN mkdir /.composer
RUN mkdir /.npm

# Configure NGINX, PHP, supervisord
COPY etc/nginx/nginx.conf /etc/nginx/nginx.conf
COPY etc/nginx/http.d/main.conf /etc/nginx/http.d/main.conf
COPY etc/php/php-fpm.d/www.conf /etc/php81/php-fpm.d/www.conf
COPY etc/php/conf.d/main.ini /etc/php81/conf.d/main.ini
COPY etc/supervisor/conf.d/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Generating a self-signed certificate to work over HTTPS
RUN mkdir /var/www/sert
RUN openssl req -x509 -nodes \
    -days 365 \
    -newkey rsa:2048 \
    -keyout /var/www/sert/domain.private.key \
    -out /var/www/sert/domain.crt \
    -subj "/C=XX/ST=StateName/L=CityName/O=CompanyName/OU=CompanySectionName/CN=CommonNameOrHostname"

# Make sure files/folders needed by the processes are accessable
# when they run under the nobody user
RUN chown -R nobody.nobody \
    /var/www/html \
    /var/www/sert \
    /var/lib/nginx \
    /var/log/nginx \
    /.composer \
    /.npm \
    /run

# Switch to use a non-root user
USER nobody

# Clone the System into the docker container
RUN git clone https://github.com/maxrys/laravel_vuejs.git .
RUN git fetch --all
RUN git switch -c origin/main
RUN /var/www/html/DEPLOY/build.sh

# Expose the port NGINX is reachable on
EXPOSE 80

# Let supervisord start NGINX and PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is working
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1/
