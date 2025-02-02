<?php

return [
    '/' => 'home/index',
    '/home' => 'home/index',
    
    '/search' => 'search/index',

    '/contacts' => 'contacts/index',
    '/send-contact-us-form' => 'contacts/send-contact-us-form',

    [
        'pattern' => '/insects/<categories:.*>',
        'route' => 'search/index',
        'encodeParams' => false,
    ],

    '/insects' => 'search/index',
];