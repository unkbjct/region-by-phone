## Installation

склонировать проект

Установить зависимости:

```sh
composer install
```

создать файл .env в корне проекта и записать ключ rest bitrix, и ключи Dadata

Сгенерировать ключ проекта:

```sh
php artisan key:generate
```

запустить проект

## about

ендпоинт скрипта [site.ru]/api/setregion

Метод: POST

принимает два параметра:

-   phone - обязательное поле;
-   lead_id - обязательное поле;

#### Успех

при успешном выполнении скрипта будет возвращен следующий ответ:

```sh
{
    "status": "success",
    "data": {
        "region": "Московская область",
        "phone": "+7 909 999-88-77"
    }
}
```

#### Возможны три ошибки:

-   недостаточно средств на балансе (Dadata);

```sh
{
  "status": "error",
  "error_message": "На аккаунте dadata не достаточно средств",
}
```

-   Превышено количество запросов в секунду или в сутки (Dadata);

```sh
{
  "status": "error",
  "error_message": "Превышино количество запросов в сутки или в секунду",
}
```

-   Не указаные нужные обязательные поля (Validation error);

```sh
{
  "status": "error",
  "error_message": "validation_error",
  "errors": {
      "phone": "phone is required field",
      "lead_id": "lead_id is required field"
  }
}
```
