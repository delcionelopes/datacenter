FROM php:7.4-fpm

RUN apt-get update && apt-get install -y software-properties-common

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    libexif-dev \
    libonig-dev

WORKDIR /var/www

# limpar o cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#instalando extensões
RUN docker-php-ext-install pdo_pgsql zip mbstring zip exif pcntl
RUN docker-php-ext-install gd bcmath
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

#instalando dependencias e habilitando o redis
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# download e instalação do composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#adicionando usuário para a aplicação Laravel
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

#Copiar o conteúdo do diretório de aplicativos existente
COPY . /var/www

#copiar permissões de diretório de aplicativo existentes
COPY --chown=www:www . /var/www

ENV PORT=8000
#permissão de execução
##COPY docker-entrypoint.sh .
##RUN chmod +x ./docker-entrypoint.sh
##ENTRYPOINT ["/docker-entrypoint.sh"]

#ajuste de permissões
RUN chown -R www-data:www-data /var/www
RUN chmod -R 777 /var/www
RUN chown -R www-data:www-data /var/www/pgdata
RUN chmod -R 777 /var/www/pgdata

#Alterar o usuário atual para www
USER www

#expõe a porta 9000 do conteiner e inicia o php-fpm server
EXPOSE 9000
CMD ["php-fpm"]