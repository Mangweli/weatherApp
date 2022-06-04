<h1 align="center">Welcome to PromoCode Rest API 👋</h1>
<p>
  <img alt="Version" src="https://img.shields.io/badge/version-1-blue.svg?cacheSeconds=2592000" />
  <a href="https://documenter.getpostman.com/view/1825277/UVsHUoN4" target="_blank">
    <img alt="Documentation" src="https://img.shields.io/badge/documentation-yes-brightgreen.svg" />
  </a>
  <a href="https://twitter.com/Kmangwels" target="_blank">
    <img alt="Twitter: Kmangwels" src="https://img.shields.io/twitter/follow/Kmangwels.svg?style=social" />
  </a>
</p>

<p>API Documentation is located at https://documenter.getpostman.com/view/1825277/Uz5GpGW3</p>

## DEPLOYING
### 🏠 [Requirements](Requirements)
<ul>
	<li>php 8.0 and above</li>
	<li>composer version 2 </li>
	<li>Mysql database </li>
    <li>Rabbit MQ - for queues or any other queueing service</li>
    <li>Redis - for Caching or any other caching service</li>
    <li>If using docker - You will only need docker and docker compose installed</li>
</ul>

## Setting up and Running the API

### ✨ [Clone](Clone the repo)

```sh
  git clone https://github.com/Mangweli/weatherApp.git
  cd weatherApp
```

### ✨ [Dependancies](Install Dependancies)

```sh
  composer install
```

### ✨ [env](Environment Variables)

> Copy `.env.example` to `.env`

```sh
  cp .env.example .env 
```
edit .env file and enter your environment variables

### ✨ [Artisan](Run Artisan Commands)

```sh
  Run php artisan optimize:clear //BUT NOT A MUST
  Run php artisan migrate
  Run php artisan serve
```

## Run tests

```sh
php artisan test or composer test
```

## DEPLOYING WITH DOCKER
### 🏠 [Requirements](Requirements)

> Docker and docker compose Installed on your machine

## Setting up and Running the API

### ✨ [Clone](Clone the repo)

```sh
  git clone https://github.com/Mangweli/weatherApp.git
  cd weatherApp
```

### ✨ [env](Environment Variables)

> Copy `.env.example` to `.env`

```sh
  cp .env.example .env 
```
<ul>
	<li>Edit .env file and enter your environment variables</li>
	<li>Make sure DB_HOST is changed to weather-mysql-db</li>
    <li>Make sure REDIS_HOST is changed to weather-redis</li>
    <li>Make sure RABBITMQ_HOST is changed to weather-rabbitmq</li>
</ul>

## Docker Commands

<p>Run the below command to bring all the services up</p>

```sh
docker-compose up -d

```

## Run Tests
```sh
docker exec -it weather-app bash
php artisan test or composer test

```
<p>Similarly you can just run</p>

```sh
docker-compose exec -T weather-app php artisan test or docker-compose exec -T weather-app composer test
```
## Running the App

<p>The app will be live on 127.0.0.1:8100</p>
<p>This can be accessed through any  browsers or any api simulation app</p>

## Crons

<p>A cron will be running every six hours to retrieve data from the external api and save them to our local database</p>

## Cache data

<p>Cache data will expire after six hour or in cases where the data changes in the database</p>

## Rabbitmq manager

<p>The app will be live on 127.0.0.1:15672</p>
<p>This can be accessed through any  browsers or any api simulation app</p>

## Tech stack

<p>Laravel - php</p>
<p>Mysql for database management</p>
<p>Nginx as webserver</p>
<p>RabbitMQ for Queueing</p>
<p>Redis for caching</p>


## Author

👤 **Kingsley**

* Website: Author Website Here
* Twitter: [@Kmangwels](https://twitter.com/Kmangwels)
* Github: [@Mangweli](https://github.com/Mangweli)
* LinkedIn: [@Kingsley Amaitsa](https://linkedin.com/in/Kingsley Amaitsa)


## Show your support

Give a ⭐️ if this project helped you!

## 📝 License

Copyright © 2022 [Kingsley](https://github.com/Mangweli).<br />

***
_This README was generated with ❤️ by [readme-md-generator](https://github.com/kefranabg/readme-md-generator)_
