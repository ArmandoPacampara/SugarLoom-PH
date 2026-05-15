<?php

return [
    'rewards' => [
        'review_points' => (int) env('SUGARLOOM_REVIEW_REWARD_POINTS', 25),
        'point_value' => (float) env('SUGARLOOM_POINT_VALUE', 1),
    ],

    'address_validation' => [
        'enabled' => (bool) env('SUGARLOOM_ADDRESS_VALIDATION_ENABLED', false),
        'provider' => env('SUGARLOOM_ADDRESS_VALIDATION_PROVIDER', 'nominatim'),
        'endpoint' => env('SUGARLOOM_NOMINATIM_ENDPOINT', 'https://nominatim.openstreetmap.org/search'),
    ],
];
