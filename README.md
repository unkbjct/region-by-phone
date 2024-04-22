## Installation

Dillinger requires [Node.js](https://nodejs.org/) v10+ to run.

Install the dependencies and devDependencies and start the server.

склонировать проект

```sh
composer install
```

создать файл .env в корне проекта и записать ключи bitrix и Regius.name
выполнить миграцию
запустить проект
запустить очереди

## about

ендпоинт скрипта [site.ru]/api/setfield

принимает два параметра:

-   phone - обязательное поле;
-   leadId - обязательное поле;

скрипт работает с помощью очереди, задержка перед каждой очередью пять секунд
