<?php
namespace backend\controllers;

use common\models\Apple;
use yii\web\Controller;
use Yii;

class AppleController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Apple::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $color = Yii::$app->request->post('color');

        $model = new Apple($color);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

}
