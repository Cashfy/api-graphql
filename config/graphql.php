<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Schemas Config
    |--------------------------------------------------------------------------
    |
    | You must provide all information related to your Schema GraphQL.
    |
    */
    'schemas' => [

        'default' => [

            'queries' => [],
            'mutations' => [
                'auth' => \App\Http\GraphQL\Webapp\Mutations\Auth::class
            ]

        ]
    ]
];