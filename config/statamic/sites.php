<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sites
    |--------------------------------------------------------------------------
    |
    | Each site should have root URL that is either relative or absolute. Sites
    | are typically used for localization (eg. English/French) but may also
    | be used for related content (eg. different franchise locations).
    |
    */

    'sites' => [

        'it' => [
            'name' => 'Italiano',
            'locale' => 'it_IT',
            'url' => '/',
        ],

        'en' => [
            'name' => 'English',
            'locale' => 'en_US',
            'url' => '/en/',
        ],

        'fr' => [
            'name' => 'Français',
            'locale' => 'fr_FR',
            'url' => '/fr/',
        ],

        'de' => [
            'name' => 'Deutsch',
            'locale' => 'de_DE',
            'url' => '/de/',
        ],

    ],
];
