<?php

return [

    'unauthorized' => [
        'title' => 'Unauthorized',
        'detail' => 'The provided credentials are incorrect.'
    ],

    'unauthenticated' => [
        'title' => 'Unauthenticated',
        'detail' => 'A valid access token must be provided to perform this request.'
    ],

    'unprocessable_content' => [
        'title' => 'Unprocessable Content'
    ],

    'unsupported_media_type' => [
        'title' => 'Unsupported Media Type',
        'detail' => 'The request must include a Content-Type header of \'application/vnd.api+json\'.',
        'parameter_not_supported' => 'The media type parameter \':parameter\' is not supported.',
        'extension_not_supported' => 'The media type extension \':extension\' is not supported.'
    ],

    'not_acceptable' => [
        'title' => 'Not Acceptable',
        'detail' => 'No acceptable JSON:API media type found in the Accept header.'
    ],
];
