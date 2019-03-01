<?php

namespace common\models\classify;

use Yii;

/**
 * This is the model class for table "{{%classify_attr}}".
 *
 * @property int $id ID
 * @property string $name 分类名称
 * @property string $name_en 分类英文
 * @property string $name_py 分类拼音
 * @property int $classify_id 分类ID
 * @property int $is_sale 销售属性：0否 1是
 * @property int $edit_type 编辑类型：0文本1单选2多选
 * @property int $datafix 0正常1删除
 */
class ClassifyAttr extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%classify_attr}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['classify_id', 'is_sale', 'edit_type','datafix'], 'integer'],
            [['classify_id', 'is_sale', 'edit_type','datafix'], 'default','value'=>0],
            [['name', 'name_en', 'name_py'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类属性名称',
            'name_en' => '分类属性英文',
            'name_py' => '分类属性拼音',
            'classify_id' => '分类ID',
            'is_sale' => '是否销售属性',
            'edit_type' => '编辑类型',
            'datafix' => 'Datafix',
        ];
    }
    public static function loadClassifyAttrById($id){
        return self::getOne('id,name,name_en,name_py ',['id'=>$id]);
    }
    public static function loadSearchNameByNameLike($name,$limit=10){
        return self::find()->select(['id','name','name_en','name_py'])->where([
            'datafix'=>self::DATAFIX,
        ])->andwhere([
            'or',
            ['like','name',$name.'%',false],
            ['like','name_en',$name.'%',false],
            ['like','name_py',$name.'%',false],
        ])->orderBy(['name'=>SORT_ASC])->limit($limit)->asArray()->all();
    }
}
