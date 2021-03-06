<?php

namespace common\models\classify;

use Yii;

/**
 * This is the model class for table "{{%classify}}".
 *
 * @property int $id ID
 * @property string $name 分类名称
 * @property string $name_en 分类英文
 * @property string $name_py 分类拼音
 * @property int $datafix 0正常1删除
 */
class Classify extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%classify}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_en', 'name_py'], 'string', 'max' => 255],
            [[ 'datafix'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '属性名称',
            'name_en' => '属性名称英文',
            'name_py' => '属性名称拼音',
            'datafix' => 'Datafix',
        ];
    }
    public static function loadClassifyById($id){
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
