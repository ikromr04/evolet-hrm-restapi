<?php

return [

    '401' => [
        'title' => 'Unauthorized',
        'detail' => 'You are not authorized to perform this action.',
        'invalid_credentials' => 'Invalid credentials. Please check your email and password.',
    ],

    '422' => [
        'title' => 'Unprocessable Content'
    ],

    '415' => [
        'title' => 'Unsupported Media Type',
        'detail' => 'The request must include a Content-Type header of \'application/vnd.api+json\'.',
        'parameter_not_supported' => 'The media type parameter \':parameter\' is not supported.',
        'extension_not_supported' => 'The media type extension \':extension\' is not supported.'
    ],

    '406' => [
        'title' => 'Not Acceptable',
        'detail' => 'No acceptable JSON:API media type found in the Accept header.'
    ],
];
