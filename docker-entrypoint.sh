#!/bin/bash

if [ | -f ".env" ]; then
    echo "Criando o arquivo env para env $APP_ENV"
    cp .env.example .env
else
    echo "arquivo .env já existe!"
fi

role=${CONTAINER_ROLE:-app}

if [ "$role" = "app" ]; then
    php artisan migrate
    php artisan key:generate
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear

    php artisan serve --port=$PORT --host=0.0.0.0 --env=.env
    exec docker-php-entrypoint "$@"
fi

