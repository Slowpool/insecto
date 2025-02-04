<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'Home';
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to('/home', true)])

?>
<div id="home-page">
    home
</div>
