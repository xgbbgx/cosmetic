<?php

namespace common\models\category;

use Yii;

/**
 * This is the model class for table "{{%brand}}".
 *
 * @property int $id
 * @property string $name 品牌名称
 * @property string $name_en 品牌英文名
 * @property string $name_py 品牌拼音
 * @property string $logo 品牌logo
 * @property int $type 类别101欧美品牌102日韩品牌103国产品牌
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $datafix 0:正常1删除
 */
class Brand extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%brand}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            ['type','in','range'=>['101','102','103']],
            [['type', 'created_at', 'created_by', 'updated_at', 'updated_by', 'datafix'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name_en', 'name_py'], 'string', 'max' => 100],
            [['logo'], 'string', 'max' => 500],
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
            'logo' => 'Logo',
            'type' => 'Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'datafix' => 'Datafix',
        ];
    }
    public static function inBrand(){
        
    }
}
