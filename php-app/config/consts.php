<?php

const DB_INT_MAX = 2147483647;
const DB_GOODS_DESCRIPTION_MAX_LEN = 1000;
const DB_GOODS_NAME_MAX_LEN = 50;
const DB_CATEGORY_NAME_MAX_LEN = 50;
const DB_GOODS_MAIN_PICTURE_MAX_LEN = 255;

// The time during which the click on url of goods item is actual. To apply changes, redo `m250204_150046_create_goods_click_statistics_table` migration or redeclare the procedure manually.
const CLICK_EXPIRATION = 1;
const CLICK_EXPIRATION_MEASURE = 'HOUR';

const POPULAR_TO_DISPLAY = 5;
const DISCOUNTED_TO_DISPLAY = 5;

const DISCOUNT_ON_DEAD = 90;
const MAX_DISCOUNT_PERCENTAGE = 99;
const MIN_DISCOUNT_PERCENTAGE = 1;

const API_URL = 'http://localhost:8000'; // here 8000 is APP_PORT from .env