# Balancer
## Тестовое задание

Задача: написать серверное приложение (aka микросервис) Balancer.

Балансер умеет:

·         принимать запрос на размещение процесса

·         принимать запрос на удаление процесса

·         принимать запрос на добавление work-машины

·         принимать запрос на удаление work-машины

·         распределять процессы между work-машинами, обеспечивая равномерную нагрузку, выполняя ребалансировку в случае добавления или удаления машин/процессов.

После размещения процесс работает вечно, пока не будет удален запросом на удаление.</br>
Процесс характеризуется необходимым кол-вом процессора и памяти.</br>
Машина характеризуется: процессором и памятью. Одно ядро берем за 100, если у машины 6 ядер, считаем для простоты, что её процессор - 600.</br>


Покрытие тестами опционально, но приветствуется.


Список технологий к использованию: PHP 7+ Symfony Mysql / Redis или любого иного персистентного хранилища.


Задание необходимо выполнить с учетом MVC паттерна, принципов SOLID, DRY.


## Реализация
Реализован как API (рест?)</br>

Балансирощик принимает запросы на удаление/добавление машины/процесса и возвращает ответ в формате JSON.</br>
В случае запроса на добавление процесса сервер находит минимально загруженную машину и бовляет процесс в нее (связывает процесс и машину в бд)</br>
В случае запроса на удаления процесса он просто удаляется</br>
В случае запроса на добаление машины ребалансировка существующих процессов не производится т.к. это подразумевает необходимость удаления как минимум части запросов и их последующего добавления (могу легко реализовать но это мало эффективно)</br>
В случае запроса на удаление машины ребалансировка выполняется (необходимо перенести активные процессы с нее на другие машины)</br>

Добавлены искючения к ответам и их логгирование

Добавлены тесты(юнит, интеграционные, функциональные)

Использован PHP 8.1, PostgreSQL 14, Symfony 6

## installation
$ composer install </br>
$ docker-compose -f docker-compose.yaml up -d

connect to db

$ symfony var:export --multiline > .env.local </br>
$ php bin/console make:migration </br>
$ php bin/console doctrine:migrations:migrate </br>
$ php bin/console doctrine:fixtures:load --purge-with-truncate </br> </br> </br>

![image](https://user-images.githubusercontent.com/44719816/185542351-c9fce06e-dd70-4fac-8b7f-aaebedc8183a.png)


[<img src='https://cdn.jsdelivr.net/npm/simple-icons@3.0.1/icons/telegram.svg' alt='telegram' height='40'>](https://t.me/alej4ndro)  
