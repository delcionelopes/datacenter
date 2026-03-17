FROM node:14-alpine as node

WORKDIR /var/www
COPY . /var/www/

RUN npm install --global cross-env
RUN npm install

VOLUME /var/www/node_modules

CMD [ "node" ]