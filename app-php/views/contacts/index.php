<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $contactForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contacts';

$okRuGroupUrl = 'https://ok.ru/insecto';
$mail = 'BukashkiIPawuchki@IhBoitsya.nice';

?>

<div id="contacts-page">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <div class="alert alert-success">
            Your message was sent. Thank you for contacting us.
        </div>

    <?php else: ?>
        <address id="contact-details">
            <h4>
                We are <strong>Insecto Inc.</strong> and here is about us.
            </h4>
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
            <aside>
                Feel free to contact us with any business offers, except cases you was walking somewhere and accidentally
                caught some minor bug and you wanted to sell it to us, except the cases when this beetle-dude is indeed big
                or
                interesting like rhinoceros-beetle.
            </aside>
        </address>

        <div id="contact-us">
            <h4>
                You can send us anything. Just fill the form.
            </h4>

            <?php $form = ActiveForm::begin(['id' => 'contact-form', 'action' => '/send-contact-us-form']); ?>
            <?= $form->field($contactForm, 'userName')->textInput(['autofocus' => true])->label('Your name') ?>
            <?= $form->field($contactForm, 'userEmail')->label('Your e-mail') ?>
            <?= $form->field($contactForm, 'subject') ?>
            <?= $form->field($contactForm, 'body')->textarea(['rows' => 6]) ?>
            <?= $form->field($contactForm, 'captcha')->widget(Captcha::class, [
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                'captchaAction' => '/contacts/captcha',
                'imageOptions' => ['alt' => 'If you see this message, then something went wrong. Try updating the page or you can report about this problem to us.'],
            ]) ?>
            <?= Html::submitButton('Send') ?>
            <?php ActiveForm::end(); ?>

        <?php endif; ?>
    </div>
</div>