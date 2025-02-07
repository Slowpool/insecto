<?php

return [
    '/' => 'home/index',
    '/home' => 'home/index',

    '/search' => 'search/index',

    '/contacts' => 'contacts/index',
    '/send-contact-us-form' => 'contacts/send-contact-us-form',

    /**
     * e.g. `/arachnida/goliath-birdeater/3`
     * at the end id is here because `goliath-birdeater` slug is not unique. see description of $name inside UnitOfgoodsRecord
     */
    // '/<categorySlug:[a-z-]{1,50}>/<goodsSlug:[a-z-]{1,50}>/<goodsItemId:\d+>' => 'goods-item/index',

    // '/<categorySlug:[a-z-]{1,50}>' => 'category/index',
];