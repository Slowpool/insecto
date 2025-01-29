<?php

return [
    '/' => 'home/index',
    '/home' => 'home/index',
    
    '/search' => 'search/index',

    '/contacts' => 'contacts/index',

    [
        'pattern' => '/insects/<categories:.*>',
        'route' => 'search/index',
        'encodeParams' => false,
    ]
];