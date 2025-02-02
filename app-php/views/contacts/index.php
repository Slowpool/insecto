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
                <label class="contact-item">
                    <b>Common phone number:</b>
                </label>
                +1 937 (1937) 19-37
            </li>
            <li>
                <label class="contact-item">
                    <b>Legal address:</b>
                </label>
                <pre>
                    Saint-Green Field Street 10g
                    2nd Floor, 3 office
                    Nasekomowsk, 220120
                    Nasekomia</pre>
            </li>
            <li>
                <label class="contact-item">
                    <b>E-mail:</b>
                </label>
                <?= Html::a($mail, "mailto:$mail") ?>
            </li>
            <li>
                <label class="contact-item">
                    <b>OK.RU group:</b>
                </label>
                <?= Html::a($okRuGroupUrl, $okRuGroupUrl) ?>
            </li>
        </ul>
        <aside>
            Feel free to contact us with any business offers, except cases you was walking somewhere and accidentally caught  some minor bug and you wanted to sell it to us, except the cases when this bug is indeed big or interesting like rhinoceros-beetle. 
        </aside>
    </address>
</div>