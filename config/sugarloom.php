<?php

return [
    'metro_manila_cities' => [
        'Quezon City',
        'Manila',
        'Makati',
        'Pasig',
        'Taguig',
        'Pasay',
        'Mandaluyong',
        'Marikina',
        'Paranaque',
        'Las Pinas',
        'Muntinlupa',
        'San Juan',
        'Caloocan',
        'Malabon',
        'Navotas',
        'Valenzuela',
        'Pateros',
    ],

    'delivery_fees' => [
        'shop_origin' => 'Pinagbuhatan, Pasig City',
        'default_fee' => 160,
        'metro_manila' => [
            'Pasig' => 90,
            'Pateros' => 100,
            'Mandaluyong' => 120,
            'Marikina' => 130,
            'Taguig' => 130,
            'Makati' => 140,
            'San Juan' => 140,
            'Quezon City' => 160,
            'Manila' => 170,
            'Pasay' => 180,
            'Paranaque' => 190,
            'Caloocan' => 200,
            'Las Pinas' => 210,
            'Muntinlupa' => 220,
            'Malabon' => 220,
            'Valenzuela' => 230,
            'Navotas' => 240,
        ],
    ],

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
