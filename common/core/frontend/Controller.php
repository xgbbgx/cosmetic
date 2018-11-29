<?php
namespace common\core\frontend;

use common\core\base\BaseController;

/**
 * frontend 前端 Controller
 * @author Alex
 *
 */
class Controller extends BaseController
{
    public function beforeAction($action){
        parent::beforeAction($action);
        return true;
    }
}