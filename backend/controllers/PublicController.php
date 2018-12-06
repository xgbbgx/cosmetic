<?php

namespace backend\controllers;

use Yii;
use common\models\category\Brand;
use common\core\backend\Controller;
use common\helpers\FileHelper;

/**
 * ClassifyController implements the CRUD actions for Brand model.
 */
class PublicController extends Controller
{
    public function actionUploads(){
        $fileName=Yii::$app->request->get('p');
        echo  FileHelper::getInstance()->file('/'.$fileName);
        exit;
    }
}
