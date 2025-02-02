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

    /**
     * e.g. `/insect/spiders/goliath-birdeater/3`
     * at the end id is here because `goliath-birdeater` slug is not unique. see description of $name inside UnitOfgoodsRecord
     */
    '/insect/<categorySlug:[a-z-]{1,50}>/<goodsSlug:[a-z-]{1,50}>/<goodsItemId:\d+>' => 'goods-item/index'
];