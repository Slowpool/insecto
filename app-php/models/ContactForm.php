<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $userName;
    public $userEmail;
    public $subject;
    public $body;
    public $captcha;

    public function rules()
    {
        return [
            [['userName', 'userEmail', 'subject', 'body'], 'required'],
            [['userEmail'], 'email'],
            [['captcha'], 'captcha', 'captchaAction' => 'contacts/captcha'],
        ];
    }

    public function formName() {
        return '';
    }

    /**
     * @return bool whether the model passes validation
     */
    public function contact($targetEmail)
    {
        $this->bodyStatisticsReport();
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setTo($targetEmail)
                ->setReplyTo([$this->userEmail => $this->userName])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();
            return true;
        }
        return false;
    }

    /**
     * Calculates statistics about how many times some words were mentioned by user.
     * @return void
     */
    private function bodyStatisticsReport() {
        $insectCount = substr_count($this->body, 'insect');
        $bugCount = substr_count($this->body, 'bug');
        $beetleCount = substr_count($this->body, 'beetle');
        $this->body = "User mentioned the further words: 'insect': $insectCount times, 'bug': $bugCount times, 'beetle': $beetleCount times. $this->body";
    }
}
