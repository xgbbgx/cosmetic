<?php
namespace common\components\spider;

use Yii;
use common\helpers\CurlHelper;

class SpiderInfo{
    
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
    
}