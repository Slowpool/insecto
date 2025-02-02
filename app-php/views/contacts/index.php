<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'Contacts';

$okRuGroupUrl = 'https://ok.ru/insecto';
$mail = 'BukashkiIPawuchki@IhBoitsya.nice';
?>

<div id="contacts-page">
    <address>
        <strong>
            Insecto Inc.
        </strong>
        <ul>
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
                <?= Html::a($mail, "mailto:$mail", ['id' => 'contact-item-email', 'class' => 
                'contact-item']) ?>
            </li>
            <li>
                <label class="contact-item-title" for="contact-item-ok-ru">
                    <b>OK.RU group:</b>
                </label>
                <?= Html::a($okRuGroupUrl, $okRuGroupUrl, ['id' => 'contact-item-ok-ru', 'class' => 
                'contact-item']) ?>
            </li>
        </ul>
        <aside>
            Feel free to contact us with any business offers, except cases you was walking somewhere and accidentally caught  some minor bug and you wanted to sell it to us, except the cases when this bug is indeed big or interesting like rhinoceros-beetle. 
        </aside>
    </address>
</div>