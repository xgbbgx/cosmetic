<?php
namespace common\components\spider;

use Yii;
use common\helpers\CurlHelper;
use common\helpers\Pinyin;

class SpiderInfo{
    /**
     * 
        $lefeng=SpiderInfo::lefeng();
        foreach ($lefeng as $k1=>$te1){
            CategoryLevel::inCategoryLevelByName($k1,'');
            foreach ($te1 as $k2=>$te2){
                CategoryLevel::inCategoryLevelByName($k2,$k1);
                foreach ($te2 as $k3=>$te3){
                    CategoryLevel::inCategoryLevelByName($te3,$k2);
                }
            }
        }
     * @return array|string
     */
    public static function lefeng(){
        $url='http://list.lefeng.com/allClassify';
        $lefengData=CurlHelper::spiderQuery($url);
        if($lefengData){
            $tree=[];
            if(preg_match('/<div class="aKindsBox">([\d\D]*?)<div class="alt-succ" id="addsuccess" style="display:none;">/i',$lefengData,$arr)){
                if(preg_match_all('/<div class="akList" id="akList[\d]*?">([\d\D]*?)<\/div>/i',$arr[1],$arr1)){
                    foreach ($arr1[1] as $r){
                        $t1='';
                        if(preg_match('/<h2>([\d\D]*?)<\/h2>/i',$r,$p1)){
                            $t1=trim(strip_tags($p1[1]));
                        }
                        $tree[$t1]=[];
                        if (preg_match_all('/<ul>([\d\D]*?)<\/ul>/i', $r,$ul)){
                            foreach ($ul[1] as $u){
                                $t2='';
                                if(preg_match('/<span class="akTitle">([\d\D]*?)<\/span>/i',$u,$p2)){
                                    $t2=trim(strip_tags($p2[1]));
                                }
                                $tree[$t1][$t2]=[];
                                if(preg_match('/<span class="akli">([\d\D]*?)<\/span>/i',$u,$p3)){
                                    if (preg_match_all('/<a[\d\D]*?>([\d\D]*?)<\/a>/i', $p3[1],$p4)){
                                        foreach ($p4[1] as $a1){
                                            $tree[$t1][$t2][]=trim($a1);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return $tree;
           // print_r($tree);
            /** $conn=Yii::$app->db;
            foreach ($tree as $k1=>$te1){
                $sql='insert into iq_product_tag(name,type) values("'.$k1.'",101)';
                $conn->createCommand($sql)->execute();
                $id1=$conn->lastInsertID;
                foreach ($te1 as $k2=>$te2){
                    $sql='insert into iq_product_tag(name,type) values("'.$k2.'",102)';
                    $conn->createCommand($sql)->execute();
                    $id2=$conn->lastInsertID;
                    $sql="insert into iq_tag_r(parent_id,child_id) values($id1,$id2)";
                    $conn->createCommand($sql)->execute();
                    foreach ($te2 as $k3=>$te3){
                        $sql='insert into iq_product_tag(name,type) values("'.$te3.'",103)';
                        $conn->createCommand($sql)->execute();
                        $id3=$conn->lastInsertID;
                        $sql="insert into iq_tag_r(parent_id,child_id) values($id2,$id3)";
                        $conn->createCommand($sql)->execute();
                    }
                }
            }
            if(preg_match('/<div class="title">([\d\D]*?)<\/div>/i',$data,$title_arr)){
                
            }
            if(preg_match('/<td[\d\D]*?>([\d\D]*?)<\/td>/i',$data,$content_arr)){
                
            }*/
            
        }
    }
    public static function get_url_contents($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//禁止直接显示获取的内容 重要
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); //5秒钟超时
        $result = curl_exec($ch);
        if(curl_errno($ch))
        {
            return false;
        }
        return $result;
    }
    public static function saveFile($url,$fileName){
        $imgUrl = htmlspecialchars($url);
        $imgUrl = str_replace("&amp;", "&", $imgUrl);
        
        //http开头验证
        if (strpos($imgUrl, "http") !== 0) {
            echo ("ERROR_HTTP_LINK");
            return;
        }
        
        preg_match('/(^https*:\/\/[^:\/]+)/', $imgUrl, $matches);
        $host_with_protocol = count($matches) > 1 ? $matches[1] : '';
        
        // 判断是否是合法 url
        if (!filter_var($host_with_protocol, FILTER_VALIDATE_URL)) {
            echo ("INVALID_URL");
            return;
        }
        
        preg_match('/^https*:\/\/(.+)/', $host_with_protocol, $matches);
        $host_without_protocol = count($matches) > 1 ? $matches[1] : '';
        
        // 此时提取出来的可能是 ip 也有可能是域名，先获取 ip
        $ip = gethostbyname($host_without_protocol);
        // 判断是否是私有 ip
        if(!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)) {
            echo ("INVALID_IP");
            return;
        }
        
        //获取请求头并检测死链
        $heads = get_headers($imgUrl, 1);
        if (!(stristr($heads[0], "200") && stristr($heads[0], "OK"))) {
            echo ("ERROR_DEAD_LINK");
            return;
        }
        //格式验证(扩展名验证和Content-Type验证)
        $fileType = strtolower(strrchr($imgUrl, '.'));
        $imgType=[".png", ".jpg", ".jpeg", ".gif", ".bmp"];
        if (!in_array($fileType, $imgType) || !isset($heads['Content-Type']) || !stristr($heads['Content-Type'], "image")) {
            echo ("ERROR_HTTP_CONTENTTYPE");
            return;
        }
        $dir=Yii::getAlias('@data-file/uploads').'/brand/';
        if(!is_dir($dir)){
            if(@mkdir($dir)){
                
            }else{
                return 'Not mkdir';
            }
        }
        $filePath=$dir.$fileName.$fileType;
        $img=self::get_url_contents($imgUrl);//获取图片
        if (file_put_contents($filePath, $img)) { //移动失败
            return '/uploads/brand/'.$fileName.$fileType;
        }
    }
    /**
     *  $brand=SpiderInfo::lefengBrand();
        $model=new Brand();
        foreach ($brand as $key=>$ba){
            foreach ($ba as $b){
                $brandModel=clone $model;
                $brandModel->type=$key;
                $brandModel->name=trim($b['name']);
                $brandModel->name_py=trim($b['name_py']);
                $brandModel->logo=$b['url'];
                $brandModel->save();
            }
        }
     * @return unknown[]|string[]|void[]
     */
    public static function lefengBrand(){
        $url='http://brand.lefeng.com/showAllBrand';
        $lefengData=CurlHelper::spiderQuery($url);
        if($lefengData){
           $tree=[];
           if(preg_match_all('/<div class="abarea">([\d\D]*?)<\/div>/i',$lefengData,$arr)){
               $py = new Pinyin();
               $i=101;
              foreach ($arr[1] as $arr1){
                  if(preg_match_all('#<img.*?alt="([^"]*)".*?src="([^"]*)"[^>]*>#i', $arr1,$arr2)){
                      if($arr2){
                          $treeA=[];
                          $j=0;
                          foreach ($arr2[1] as $arr4){
                              $treeA['name']=$arr4; 
                              $namePy=$py->getpy($arr4,true);
                              $treeA['name_py']=$namePy;
                              $url=self::saveFile($arr2[2][$j], $namePy);
                              $treeA['url']=$url;
                              $tree[$i][]=$treeA;
                              $j++;
                          }
                          
                      }
                  }
                  $i++;
              }
           }
           return $tree;
        }
    }
}