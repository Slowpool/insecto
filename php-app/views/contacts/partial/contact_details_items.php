<?php

/** @var yii\web\View $this */
use yii\bootstrap5\Html;

$okRuGroupUrl = 'https://ok.ru/insecto';
$mail = 'BukashkiIPawuchki@IhBoitsya.nice';

?>


<ul id="contacts-details-items">
    <li>
        <label for="phone-number">
            <b>Common phone number:</b>
        </label>
        <div id="phone-number" class="contact-item">
            +1 937 (1937) 19-37
        </div>
    </li>
    <li>
        <label class="contact-item-title" for="contact-item-legal-address">
            <b>Legal address:</b>
        </label>
        <pre id="contact-item-legal-address" class="contact-item">Saint-Green Field Street 10g
                    2nd Floor, 3 office
                    Nasekomowsk, 220120
                    Nasekomia</pre>
    </li>
    <li>
        <label class="contact-item-title" for="contact-item-email">
            <b>E-mail:</b>
        </label>
        <?= Html::a($mail, "mailto:$mail", [
            'id' => 'contact-item-email',
            'class' =>
                'contact-item'
        ]) ?>
    </li>
    <li>
        <label class="contact-item-title" for="contact-item-ok-ru">
            <b>OK.RU group:</b>
        </label>
        <?= Html::a($okRuGroupUrl, $okRuGroupUrl, [
            'id' => 'contact-item-ok-ru',
            'class' =>
                'contact-item'
        ]) ?>
    </li>
</ul>