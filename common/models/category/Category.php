<?php

namespace common\models\category;

use Yii;
use yii\db\Exception;
use common\helpers\Pinyin;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property string $name 分类
 * @property string $name_en 英文名
 * @property string $name_py 名称拼音
 * @property int $parent_id 父类id
 * @property int $weight 权重
 * @property int $level 级别1为1级
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
            [['level','type','parent_id','weight', 'created_at', 'created_by', 'updated_at', 'updated_by', 'datafix'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name_en', 'name_py'], 'string', 'max' => 100],
            [['type','parent_id'], 'default', 'value' => '0'],
            [['level'], 'default', 'value' => '1'],
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
            'level' => 'Level',
            'type' => 'Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'datafix' => 'Datafix',
        ];
    }
    public static function initCategoryLevel($cCategoryName,$pCategoryName='',$level=1){
        $py = new Pinyin();
        $tr = Yii::$app->db->beginTransaction();
        try {
            $pCategoryId=0;
            if($pCategoryName){
                $pLevel=$level-1;
                $pCategory=Category::findOne(['name'=>$pCategoryName,'type'=>$pLevel]);
                $pCategoryId=$pCategory->id;
            }
            
            $cCategory=Category::findOne(['name'=>$cCategoryName,'type'=>$type]);
            if(empty($cCategory)){
                $cCategory=new Category();
                $cCategory->name=$cCategoryName;
                $cCategory->name_py=$py->getpy($cCategoryName,true);
                $cCategory->level=$level;
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
    
    public static function loadCategoryNumByArr($arr){
        $where = '';
        if(isset($arr['sWhere']) && $arr['sWhere']){
            $where=$arr['sWhere'];
        }
        return self::findBySql('select count(*) from
(select t1.id cid1,t1.name name1,t1.parent_id pid1,t2.id cid2,t2.name name2,t2.parent_id pid2
from t_category t1 left join t_category t2 on t1.id=t2.parent_id where t1.parent_id=0 and t1.datafix=0 and t2.datafix=0) t3
left join t_category t4 on t3.cid2=t4.parent_id and t4.datafix=0 '.$where)->scalar();
    }
    public static function loadCategoryByArr($arr){
        $order=empty($arr['sOrder']) ? '  ':$arr['sOrder'];
        $where = '';
        if(isset($arr['sWhere']) && $arr['sWhere']){
            $where=$arr['sWhere'];
        }
        $sql='select t3.cid1,t3.name1,t3.cid2 ,t3.name2 ,t4.id as cid3,
t4.name as name3 from
(select t1.id cid1,t1.name name1,t1.parent_id pid1,t2.id cid2,t2.name name2,t2.parent_id pid2
from t_category t1 left join t_category t2 on t1.id=t2.parent_id where t1.parent_id=0 and t1.datafix=0 and t2.datafix=0) t3
left join t_category t4 on t3.cid2=t4.parent_id and t4.datafix=0
 '.$where.' '.$order.' '.@$arr['sLimit'];
        return self::findBySql($sql)->asArray()->all();
    }
    
    public static function loadCategoryTree(){
        $category=self::getAll('id,name,parent_id,level,type', ['datafix'=>self::DATAFIX]);
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
    
    /**
     * @param $pid
     * @return array
     */
    public function getCategoryList($pid)
    {
        $model = self::findAll(array('parent_id'=>$pid));
        return ArrayHelper::map($model, 'id', 'name');
    }
}
