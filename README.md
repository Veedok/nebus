# Nebus

[Задача](./Task.md)

### Собрать контейнер 
```text
docker compose up -d
```
### Зайти в контейнер 
```text
docker compose exec app bash
```
### Установить зависимости
```text
composer install
```
### Создать БД
```text
php bin/console doctrine:database:create
```
### Провести миграции
```text
php bin/console doctrine:migrations:migrate
```
### Заполнит БД
```text
php bin/console doctrine:fixtures:load
```