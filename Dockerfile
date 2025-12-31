FROM gas0r/php7.4-fpm

# Instala dependências de sistema necessárias para algumas extensões
RUN apt-get update && apt-get install -y \
    git \
    libpq-dev \
    libxml2-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libicu-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Instala extensões PHP usando o script docker-php-ext-install
RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mysqli \
    soap \
    zip \
    gd \
    intl \
    opcache \
    exif 

# Limpa o cache para reduzir o tamanho final da imagem
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'c8b085408188070d5f52bcfe4ecfbee5f727afa458b2573b8eaaf77b3419b0bf2768dc67c86944da1544f06fa544fd47') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

EXPOSE 9000

RUN chown -R www-data:www-data \
    /var/www