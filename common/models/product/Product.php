<?php

namespace common\models\product;

use Yii;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property int $id ID
 * @property string $name 名称
 * @property string $name_en 名称英文
 * @property string $name_py 名称拼音
 * @property string $cover 主图
 * @property string $image json图片集合
 * @property int $brand_id 品牌ID
 * @property int $category_id 分类ID
 * @property string $effect_ids 功效ids
 * @property string $skin_ids 适用皮肤ID
 * @property int $created_by
 * @property int $created_at
 * @property int $updated_by
 * @property int $updated_at
 * @property int $datafix 0正常1删除
 */
class Product extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_id', 'category_id', 'created_by', 'created_at', 'updated_by', 'updated_at', 'datafix'], 'integer'],
            [['name', 'name_en', 'name_py', 'cover', 'effect_ids', 'skin_ids'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 3000],
            [['name', 'brand_id'], 'unique', 'targetAttribute' => ['name', 'brand_id']],
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
            'cover' => 'Cover',
            'image' => 'Image',
            'brand_id' => 'Brand ID',
            'category_id' => 'Category ID',
            'effect_ids' => 'Effect Ids',
            'skin_ids' => 'Skin Ids',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'datafix' => 'Datafix',
        ];
    }
    
    public static function getColumn($table){
        return self::findBySql('show full columns from '.$table)->asArray()->column();
    }
}
