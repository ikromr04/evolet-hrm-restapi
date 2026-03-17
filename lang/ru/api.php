<?php

return [

    'unauthorized' => [
        'title' => 'Неавторизован',
        'detail' => 'Указанные учетные данные некорректны.'
    ],

    'unauthenticated' => [
        'title' => 'Неаутентифицирован',
        'detail' => 'Для выполнения этого запроса необходимо предоставить действительный токен доступа.',
    ],

    'unprocessable_content' => [
        'title' => 'Невалидные данные'
    ],

    'unsupported_media_type' => [
        'title' => 'Неподдерживаемый тип медиа',
        'detail' => 'Запрос должен включать заголовок Content-Type с значением \'application/vnd.api+json\'.',
        'parameter_not_supported' => 'Параметр типа медиа \':parameter\' не поддерживается.',
        'extension_not_supported' => 'Расширение типа медиа \':extension\' не поддерживается.'
    ],

    'not_acceptable' => [
        'title' => 'Неприемлемо',
        'detail' => 'В заголовке Accept не найдено приемлемого типа медиа JSON:API.'
    ],
];
