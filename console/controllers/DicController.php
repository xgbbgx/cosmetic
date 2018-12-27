<?php
namespace console\controllers;

use yii\console\Controller;
use common\services\SpliteService;
class DicController extends Controller
{
    public function actionIndex()
    {
        header("Content-type:text/html;charset=utf-8");
        ignore_user_abort(); 
        set_time_limit(0);
        $startTime=microtime(true);
        echo 'Data start...';
        $endTime=microtime(true);
        $totalTime = ($endTime - $startTime) . "s!\n";
        $memory = ( ! function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2).'MB';
        echo ("useTime:{$totalTime}! memory:" . $memory);
        exit;
    }
    
    public function actionExport(){
        header("Content-type:text/html;charset=utf-8");
       SpliteService::exportPhpanalysis();
    }
    public function actionMake(){
        header("Content-type:text/html;charset=utf-8");
        SpliteService::makePhpanalysis();
    }
}
