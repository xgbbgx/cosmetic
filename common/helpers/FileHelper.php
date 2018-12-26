<?php
namespace common\helpers;
use Yii;
class FileHelper{
    //单例模式
    private static $instance = NULL;
    private static $uploadDir = '';
    
    public static function getInstance($uploadDir = "")
    {
        if(self::$instance === null)
        {
            $classname = __CLASS__;
            self::$instance = new $classname();
            self::$uploadDir = empty($uploadDir) ? Yii::getAlias('@data-file/uploads') : $uploadDir;
        }
        return self::$instance;
    }
    public function file($fileName){
        return $this->readFile(self::$uploadDir.$fileName);
    }
    /**
     * @desc 读取文件流并输出到浏览器
     * @param string $file 原始文件路径
     * @return boolean|string
     */
    public function readFile($file, $fileName = ''){
        if (!file_exists($file))
            return false;
            switch (self::getExt($file))
            {
                case 'jpg':
                    header( "Content-type: image/jpg");
                    break;
                case 'gif':
                    header( "Content-type: image/gif");
                    break;
                case 'png':
                    header("Content-Type: image/png");
                    break;
                case 'pdf':
                    header('Content-Type: application/pdf');
                    break;
                case 'xls':
                case 'xlxs':
                case 'xlsx':
                    header("Content-type:application/vnd.ms-excel");
                    header("Content-Disposition:attachement;filename=$fileName");
                    break;
                case 'swf':
                    header("Content-type:application/x-shockwave-flash");
                    break;
                case 'wav':
                    header("Content-type:audio/wav");
                    break;
                default:
                    header( "Content-type: image/jpg");
            }
            ob_clean();
            ob_start();
            $file = fread(fopen($file,"r"), filesize($file));
            ob_end_flush();
            return $file;
    }
    
    //获取文件后缀
    public static function getExt($file) {
        $tmp = explode('.',$file);
        return end($tmp);
    }
    
    public static function putFile(){
        
    }
}