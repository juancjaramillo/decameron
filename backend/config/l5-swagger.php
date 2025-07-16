<?php

return [
    'default' => 'default',

    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'Decameron API',
            ],

            'routes' => [
                // Ruta donde sirve la documentación interactiva
                'api' => 'api/documentation',
            ],

            'paths' => [
                'use_absolute_path'      => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),
                'swagger_ui_assets_path' => env('L5_SWAGGER_UI_ASSETS_PATH', 'vendor/swagger-api/swagger-ui/dist/'),
                'docs_json'              => 'api-docs.json',
                'docs_yaml'              => 'api-docs.yaml',
                'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),
                'annotations'            => [
                    base_path('app'),
                ],
            ],
        ],
    ],

    'defaults' => [
        // Rutas para la UI y callbacks de OAuth
        'routes' => [
            'docs'            => 'docs',
            'oauth2_callback' => 'api/oauth2-callback',
            'middleware'      => [
                'api'             => [],
                'asset'           => [],
                'docs'            => [],
                'oauth2_callback' => [],
            ],
        ],

        // Paths para almacenamiento y vistas
        'paths' => [
            'docs'     => storage_path('api-docs'),
            'views'    => base_path('resources/views/vendor/l5-swagger'),
            'base'     => env('L5_SWAGGER_BASE_PATH', null),
            'excludes' => [],
        ],

        // Proxy CORS y X-Forwarded headers
        'proxy' => env('L5_SWAGGER_PROXY', false),

        // Ordenación de operaciones en UI
        'operations_sort' => env('L5_SWAGGER_OPERATIONS_SORT', null),

        // URL adicional de configuración si se requiere (p.ej. remoto)
        'additional_config_url' => env('L5_SWAGGER_ADDITIONAL_CONFIG_URL', null),

        // URL del validador de Swagger (p.ej. nul para desactivar)
        'validator_url' => env('L5_SWAGGER_VALIDATOR_URL', null),

        // Definición de seguridad Bearer JWT
        'securityDefinitions' => [
            'securitySchemes' => [
                'bearerAuth' => [
                    'type'         => 'http',
                    'scheme'       => 'bearer',
                    'bearerFormat' => 'JWT',
                    'description'  => 'Bearer {token}',
                    'in'           => 'header',
                    'name'         => 'Authorization',
                ],
            ],
            'security' => [
                ['bearerAuth' => []],
            ],
        ],

        'generate_always'    => env('L5_SWAGGER_GENERATE_ALWAYS', false),
        'generate_yaml_copy' => env('L5_SWAGGER_GENERATE_YAML_COPY', false),

        'ui' => [
            'display' => [
                'dark_mode'    => env('L5_SWAGGER_UI_DARK_MODE', false),
                'doc_expansion'=> env('L5_SWAGGER_UI_DOC_EXPANSION', 'none'),
                'filter'       => env('L5_SWAGGER_UI_FILTERS', true),
            ],
            'authorization' => [
                'persist_authorization' => env('L5_SWAGGER_UI_PERSIST_AUTHORIZATION', true),
            ],
        ],

        // Forzar host único para Swagger
        'constants' => [
            'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://localhost:8000'),
        ],
    ],
];
