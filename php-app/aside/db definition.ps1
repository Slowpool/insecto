# not a complete list. just writing them here because in terminal they may disappear when you press arrow key accidentaly

php yii migrate/create create_category_table --fields="name:string(50):notNull:check('LENGTH(TRIM(name)) > 0')"
php yii migrate/create create_unit_of_goods_table --fields="measure_unit:notNull:check('measure_unit in (\'g\', \'u\')'):comment('g - gramm, u - unit'),count:integer:notNull:check('count > 0'),name:string(50):notNull:check('LENGTH(TRIM(name)) > 0'),category_id:integer:notNull:foreignKey(category),description:string:check('LENGTH(TRIM(description)) > 0')"

docker run -it php-app php yii migrate/create add_slug_column_to_unit_of_goods_table --fields="slug:string(50):notNull"