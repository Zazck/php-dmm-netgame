# PHP DMM NETGAME

This project is inspired by [OOI v3](https://github.com/acgx/ooi3).

Only gadget info extracted

## Requirements

Server IP must not be recognized as China's

PHP v7.1+

Composer

GuzzleHTTP

## Feature

Proxy In-game payment

Auto-update ST

Auto-set Frame Height

Profile Completing

## Deploy

Download project files

Download composer.phar and put it in project folder

run command ```php composer.phar install```

change config in php

upload ```vendor``` folder and ```api.php``` to your php server

If it's not working, download [cacert.pem](https://curl.haxx.se/ca/cacert.pem)

upload to server and modify the cacert file path in ```api.php```
