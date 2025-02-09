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
### Документация доступна на
```
http://localhost/org/doc
```

### Немного не понял строку задания *ограничить уровень вложенности деятельностей 3 уровням* Поэтому в методе генерации организаций по виду деятельности добавил не обязательный параметр, отвечающий за то как глубоко копаем, если не передан выведет все до последней цепочки, если же передан будет смотреть на переданную величину вложенности