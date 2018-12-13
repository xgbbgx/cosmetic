<?php

namespace common\models\category;

use Yii;
use yii\db\Exception;
use common\helpers\Pinyin;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property string $name 分类
 * @property string $name_en 英文名
 * @property string $name_py 名称拼音
 * @property int $parent_id 父类id
 * @property int $weight 权重
 * @property int $type 类别
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $datafix 0:正常1删除
 */
class Category extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type','parent_id','weight', 'created_at', 'created_by', 'updated_at', 'updated_by', 'datafix'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name_en', 'name_py'], 'string', 'max' => 100],
            [['name','type'], 'unique', 'targetAttribute' => ['name', 'type']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'name_en' => 'Name En',
            'name_py' => 'Name Py',
            'parent_id' => 'Parent ID',
            'weight' => 'Weight',
            'type' => 'Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'datafix' => 'Datafix',
        ];
    }
    public static function initCategoryLevel($cCategoryName,$pCategoryName='',$type=1){
        $py = new Pinyin();
        $tr = Yii::$app->db->beginTransaction();
        try {
            $pCategoryId=0;
            if($pCategoryName){
                $pType=$type-1;
                $pCategory=Category::findOne(['name'=>$pCategoryName,'type'=>$pType]);
                $pCategoryId=$pCategory->id;
            }
            
            $cCategory=Category::findOne(['name'=>$cCategoryName,'type'=>$type]);
            if(empty($cCategory)){
                $cCategory=new Category();
                $cCategory->name=$cCategoryName;
                $cCategory->name_py=$py->getpy($cCategoryName,true);
                $cCategory->type=$type;
                $cCategory->parent_id=$pCategoryId;
                if(!$cCategory->save()){
                    print_r($cCategory->errors);
                    $tr->rollBack();
                    return;
                }
            }
            $cCategoryId=$cCategory->id;
            
            //提交
            $tr->commit();
        } catch (Exception $e) {
            //回滚
            $tr->rollBack();
            print_r($e);
            return ;
        }
    }
    
    public static function loadCategoryTree(){
        $category=self::getAll('id,name,parent_id,type', ['datafix'=>self::DATAFIX]);
        return self::getTree($category,0);
    }
    static function getTree($data, $pId)
    {
        $tree = '';
        foreach($data as $k => $v)
        {   
            if($v['parent_id'] == $pId)   
            {        //父亲找到儿子      
                $v['parent_id'] = self::getTree($data, $v['id']);   
                $tree[] = $v;
                //unset($data[$k]);
            }  
        } 
        return $tree; 
    }
}
