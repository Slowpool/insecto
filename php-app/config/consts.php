<?php

const DB_GOODS_DESCRIPTION_MAX_LEN = 1000;
const DB_GOODS_NAME_MAX_LEN = 50;
const DB_CATEGORY_NAME_MAX_LEN = 50;

// measured in hours. The time during which the click on url of goods item is actual. To apply changes, redo `m250204_150046_create_goods_click_statistics_table` migration or redeclare the procedure manually.
const CLICK_EXPIRATION = 1;
const CLICK_EXPIRATION_MEASURE = 'HOUR';
