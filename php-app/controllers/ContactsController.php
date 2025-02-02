<?php

namespace app\controllers;

use Yii;

use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ContactForm;

class ContactsController extends BaseControllerWithCategories
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'send-contact-us-form' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays contacts page.
     *
     * @return Response|string
     */
    public function actionIndex()
    {
        $contactForm = new ContactForm;
        return $this->render('index', compact('contactForm'));
    }

    public function actionSendContactUsForm()
    {
        $contactForm = new ContactForm;
        if ($contactForm->load(Yii::$app->request->post(), '') && $contactForm->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->redirect('/contacts');
        }

        throw new BadRequestHttpException();
    }
}
