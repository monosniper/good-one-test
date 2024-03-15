1. Настройте данные подключения к БД
2. Выполните миграцию

```bash
php artisan migrate
```

3. Выполните сиды

```bash
php artisan db:seed
```

4. Запрос к эндпоинту <strong>POST</strong> `api/v1/calculate`

Пример запроса: 
```json
{
    "data": [
        {
            "name": "Брюки",
            "count": 20
        },
        {
            "name": "Рубашка",
            "count": 30
        }
    ]
}
```

Пример ответа:
```json
{
    "data": {
        "success": true,
        "result": {
            "нехватка": {
                "Ткань-1": 16,
                "Нить": 160
            },
            "остаток": {
                "Замок": 980,
                "Ткань-2": 176,
                "Пуговица": 350
            }
        }
    }
}
```