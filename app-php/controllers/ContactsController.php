<?php

namespace app\controllers;

use Yii;

use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ContactForm;

class ContactsController extends ControllerWithCategories
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            // 'access' => [
            //     'class' => \yii\filters\AccessControl::class,
            //     'rules' => [
            //         'actions' => ['captcha', 'index'],
            //         'allow' => true,
            //     ],
            // ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    // TODO fill

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
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionIndex()
    {
        $contactForm = new ContactForm;
        if ($contactForm->load(Yii::$app->request->post(), '') && $contactForm->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('index', compact('contactForm'));
    }
}
