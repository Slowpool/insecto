# not a complete list. just writing them here because in terminal they may disappear when you press arrow key accidentaly

php yii migrate/create create_category_table --fields="name:string(50):notNull:check('LENGTH(TRIM(name)) > 0')"
php yii migrate/create create_unit_of_goods_table --fields="measure_unit:notNull:check('measure_unit in (\'g\', \'u\')'):comment('g - gramm, u - unit'),count:integer:notNull:check('count > 0'),name:string(50):notNull:check('LENGTH(TRIM(name)) > 0'),category_id:integer:notNull:foreignKey(category),description:string:check('LENGTH(TRIM(description)) > 0')"

docker run -it php-app php yii migrate/create add_slug_column_to_unit_of_goods_table --fields="slug:string(50):notNull"

php yii migrate/create create_goods_click_statistics_table --fields="unit_of_goods_id:integer:notNull:foreignKey(unit_of_goods),created_at:datetime:notNull:defaultExpression('CURRENT_TIMESTAMP')"

php yii migrate/create create_price_offer_table --fields="unit_of_goods_id:integer:notNull:foreignKey(unit_of_goods):unique,new_price:integer:notNull:check('price > 0')"

1..47 | ForEach-Object { New-Item -Name $_ -ItemType Directory } # creates directories with names 1, 2, 3, ..., 47

1..47 | ForEach-Object {
    Copy-Item -Path "C:\EasyPHP-Devserver-17\eds-www\PHP\yii projects\insecto\php-app\web\ladybug.jpg" -Destination "C:\EasyPHP-Devserver-17\eds-www\PHP\yii projects\insecto\php-app\web\goods-images\$_\main.jpg"
}

php yii migrate/create add_discount_percentage_column_to_price_offer_table --fields="discount_percentage:integer:notNull:check('discount_percentage > 0 AND discount_percentage < 100')"

php yii migrate/create add_main_picture_column_to_unit_of_goods_table --fields="main_picture:string(255)"

./vendor/bin/openapi controllers/API -o openapi.yaml