FROM node:11.13.0
MAINTAINER Lê Văn Tiến<tienhh1994@gmail.com>
ENV NODE_ENV=development
WORKDIR /usr/src/app

COPY package*.json ./
RUN NODE_ENV=development npm install
ENV NODE_PATH=/usr/src/app/node_modules
RUN npm install -g @vue/cli
# COPY . .
EXPOSE 7717
CMD ["npm","run","serve-dev"]
