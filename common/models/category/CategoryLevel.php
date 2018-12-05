<?php

namespace common\models\category;

use Yii;
use common\helpers\Pinyin;
use yii\db\Exception;

/**
 * This is the model class for table "{{%category_level}}".
 *
 * @property int $id
 * @property int $c_category_id 分类id
 * @property int $p_category_id 父类id
 * @property int $type 分层
 * @property int $datafix 0正常1删除
 */
class CategoryLevel extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%category_level}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['c_category_id', 'p_category_id', 'type', 'datafix'], 'integer'],
            [['c_category_id', 'p_category_id'], 'unique', 'targetAttribute' => ['c_category_id', 'p_category_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'c_category_id' => 'C Category ID',
            'p_category_id' => 'P Category ID',
            'type' => 'Type',
            'datafix' => 'Datafix',
        ];
    }
    public static function inCategoryLevelByName($cCategoryName,$pCategoryName=''){
        $py = new Pinyin();
        $tr = Yii::$app->db->beginTransaction();
        try {
            $cCategory=Category::findOne(['name'=>$cCategoryName]);
            if(empty($cCategory)){
                $cCategory=new Category();
                $cCategory->name=$cCategoryName;
                $cCategory->name_py=$py->getpy($cCategoryName,true);
                if(!$cCategory->save()){
                    print_r($cCategory->errors);
                    $tr->rollBack();
                    return;
                }
            }
            $cCategoryId=$cCategory->id;
            $pCategoryId=0;
            if($pCategoryName){
                $pCategory=Category::findOne(['name'=>$pCategoryName]);
                if(empty($pCategory)){
                    $pyp=clone $py;
                    $pCategory=new Category();
                    $pCategory->name=$pCategoryName;
                    $pCategory->name_py=$py->getpy($pCategoryName,true);
                    if(!$pCategory->save()){
                        print_r($pCategory->errors);
                        $tr->rollBack();
                        return;
                    }
                }
                $pCategoryId=$pCategory->id;
            }
            $categoryLevel=CategoryLevel::findOne(['c_category_id'=>$cCategoryId,'p_category_id'=>$pCategoryId]);
            if(empty($categoryLevel)){
                $categoryLevel=new CategoryLevel();
                $categoryLevel->c_category_id=$cCategoryId;
                $categoryLevel->p_category_id=$pCategoryId;
                if(!$categoryLevel->save()){
                    print_r($categoryLevel->errors);
                    $tr->rollBack();
                    return;
                }
            }
            //提交
            $tr->commit();
        } catch (Exception $e) {
            //回滚
            $tr->rollBack();
            print_r($e);
            return ;
        }
    }
}
