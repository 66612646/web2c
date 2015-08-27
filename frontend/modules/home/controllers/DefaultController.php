<?php
namespace frontend\modules\home\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
/* use frontend\modules\tag\models\Tag;
use frontend\modules\home\components\Controller;
use frontend\modules\home\models\Question;
use frontend\modules\home\models\QuestionForm;
use frontend\modules\home\models\QuestionSearch;
use frontend\modules\home\models\Answer;
use frontend\modules\home\models\AnswerSearch; */

/**
 * DefaultController implements the CRUD actions for Home model.
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
