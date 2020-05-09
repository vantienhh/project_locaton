## 1/ Cài docker

## 2/ setup môi trường
#### - env:
```
cp services/backend/.env.example services/backend/.env
```
```
cp services/fontend/.env.example services/fontend/.env
```
#### - chmod:
```$xslt
docker-compose exec aimesoft_backend chmod -R 777 storage
```
#### - composer:
```$xslt
docker-compose exec aimesoft_backend composer install
```
#### - db:
```$xslt
docker-compose exec aimesoft_backend php artisan migrate:refresh --seed --force
```
#### - laravel passport:
```$xslt
docker-compose exec aimesoft_backend php artisan passport:install
```
- copy **Client ID** thứ 2 và **CLIENT_SECRET** tương ứng vào file **.env** của **backend** 

## 3/ Run
- Vào http://localhost:7719 (ports của service **aimesoft_fontend**) 
- Đăng nhập
