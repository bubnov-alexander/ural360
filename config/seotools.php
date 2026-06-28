<?php

return [
    'meta' => [
        'defaults' => [
        ],
        'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
            'norton' => null,
        ],
        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        'defaults' => [
            'title' => false,
            'description' => false,
            'url' => false,
            'type' => false,
            'site_name' => false,
            'images' => [],
        ],
    ],
    'twitter' => [
        'defaults' => [
        ],
    ],
    'json-ld' => [
        'defaults' => [
            'title' => false,
            'description' => false,
            'url' => false,
            'type' => 'WebPage',
            'images' => [],
        ],
    ],
];
