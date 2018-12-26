<?php
namespace common\services;
use common\services\phpanalysis\PhpAnalysis;
use common\services\pscws4\PSCWS4;
use common\services\vicword\lib\VicWord;
use common\services\vicword\lib\VicDict;


class SpliteService{
    
    /**
     * 
     * @param string $data
     * @return string
     */
    public static function getPhpanalysisKeywords($data)
    {       
        if(empty($data)){
            return ;
        }
        //这个地方写上phpanalysis对应放置路径
        require_once   'phpanalysis/phpanalysis.class.php';
        PhpAnalysis::$loadInit = false;
        $pa = new PhpAnalysis ( 'utf-8', 'utf-8', false );
        
        $pa->LoadDict ();
        $pa->SetSource ( $data );
        $pa->StartAnalysis ( true );
        $tags = $pa->GetFinallyResult (','); // 获取文章中的五个关键字
        if($tags){
            $tags=substr($tags, 1);
        }
        $tagsArr=explode(',', $tags);
        return $tagsArr;
    }
    /**
     * https://www.jianshu.com/p/ebaa0dbbfa91
     * @param unknown $data
     * @return void|array
     */
    public static function getPscwsKeywords($data)
    {
        if(empty($data)){
            return ;
        }
        
        require( 'pscws4/pscws4.class.php');
        
        $pscws = new PSCWS4();
        $pscws->set_charset("utf8");
        $pscws->set_dict( dirname(__FILE__) .'//pscws4//etc//dict.utf8.xdb');
        $pscws->set_rule( dirname(__FILE__) .'//pscws4//etc//rules.utf8.ini');
        $pscws->set_dict( dirname(__FILE__) .'//pscws4//etc//mydict.txt');
        $pscws->set_ignore(true);
        $pscws->send_text($data);
        $tags='';
        while ($some = $pscws->get_result()){
            foreach ($some as $word){
                $tags .=','.$word['word'];
            }
        } 
        $pscws->close();
        if($tags){
            $tags=substr($tags, 1);
        }
        $tagsArr=explode(',', $tags);
        return $tagsArr;
    }
    
    public static function  vicword($data){
        define('_VIC_WORD_DICT_PATH_',__DIR__.'/vicword/Data/dict.json');   
        //type: 词典格式
        $fc = new VicWord('json');  
        //长度优先分词
        $ar = $fc->getWord($data);
        $tagsArr=[];
        if($ar){
            foreach ($ar as $a){
                $tagsArr[]=$a[0];
            }
        }
        return $tagsArr;
    }
    public static function vicwordAdd($word){
        define('_VIC_WORD_DICT_PATH_',__DIR__.'/vicword/Data/dict.json');
        //type: 词典格式
        $dict=new VicDict('json');
        $dict->add($word,'n');
        $dict->save();
    }
    /**
     *噪声词剔除
     *@author [Alex] <[<xuguobao@xmebank.com>]>
     */
    public static function rtnTags($tagsArr){
        if($tagsArr && is_array($tagsArr)){
            $stopWordArr=file(dirname(__FILE__).'/phpanalysis/stopword.txt');
            if($stopWordArr){
                foreach ($tagsArr as $k=>$tag) {
                    foreach ($stopWordArr as $sword) {
                        if(trim($tag)==trim($sword)){
                            unset($tagsArr[$k]);
                            break;
                        }
                    }
                }
                $tagsArr=array_values($tagsArr);
            }
        }
        return $tagsArr;
    }
    /**
     *噪声词判断
     *@author [Alex] <[<xuguobao@xmebank.com>]>
     */
    public static function isStopWord($stopWord){
        $stopWordArr=file(dirname(__FILE__).'/phpanalysis/stopword.txt');
        if($stopWordArr){
            foreach ($stopWordArr as $v) {
                if(trim($stopWord)==trim($v)){
                    return true;
                }
            }
        }
        return false;
    }
    
}