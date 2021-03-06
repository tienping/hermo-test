<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\Product;
use app\models\ProductSearch;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
	
	/* CUSTOMIZATION: setup action to do site page routing */
	public function actionIndex() {
		$searchModel = new ProductSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		return $this->render('index', []);
	}
	
	public function actionStep1($field = "name", $order = "ASC") {
		$searchModel = new ProductSearch();
		
		$params = Yii::$app->request->queryParams;
		$params['field'] = $field;
		$params['order'] = ($order == 'ASC') ? SORT_ASC : SORT_DESC;
		
		$dataProvider = $searchModel->search($params);
		
		return $this->render('step1', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'params' => $params
		]);
	}
	
	public function actionStep2($id, $quantity = 1) {
		$searchModel = new ProductSearch();
		$searchModel->id = $id;
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		return $this->render('step2', [
			'id' => $id,
			'quantity' => $quantity,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider
		]);
	}
	
	public function actionStep3($id, $quantity = 1, $shippingArea, $promoCode ="") {
		$searchModel = new ProductSearch();
		$searchModel->id = $id;
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		return $this->render('step3', [
			'id' => $id,
			'quantity' => $quantity,
			'shippingArea' => $shippingArea,
			'promoCode' => $promoCode,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider
		]);
	}
	/* CUSTOMIZATION: end */
	
	public function actionEntry()
    {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // valid data received in $model

            // do something meaningful here about $model ...

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // either the page is initially displayed or there is some validation error
            return $this->render('entry', ['model' => $model]);
        }
    }
}
