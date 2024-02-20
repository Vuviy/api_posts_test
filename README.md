

## Info

- php - ^8.0.2
- db - MySQL
- Api documentation in file "Api Posts.postman_collection.json" in root
- Scheme of DB in file "Scheme_DB.JPG" in root


## Install

- copy repository from GitHub;
- run your local server;
- in root of project run commands:
  - composer install
  - php artisan migrate
  - php artisan db:seed


## Postman

- import Api Posts.postman_collection.json file in Postman for send requests;
- Add you baseUrl to Postman Environments and use it


## Admin

Admin credentials:
- login - admin@admin.com
- password - password

## Somethings

 Авторизія через Laravel Sanctum напевно повинна бути реалізована дещо по-іншому. В докуменації вказано що спочатку потрібно надсилати запит на роут /sanctum/csrf-cookie і далі передавати заголовок X-XSRF-TOKEN, але я передаю заголовок Authorization з отриманим токеном функцією createToken що теж сказано в документації. 

 UPD: роут /sanctum/csrf-cookie потрбен для реалізації SPA. Оскільки задача була розробити API тому методи які я використав вважю коректними.
