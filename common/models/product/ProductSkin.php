<?php

namespace common\models\product;

use Yii;

/**
 * This is the model class for table "{{%product_skin}}".
 *
 * @property int $id ID
 * @property string $name 适用皮肤名称
 * @property string $name_en 适用皮肤英文
 * @property string $name_py 适用皮肤拼音
 * @property int $created_by
 * @property int $created_at
 * @property int $updated_by
 * @property int $updated_at
 * @property int $datafix 0正常1删除
 */
class ProductSkin extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_skin}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_by', 'created_at', 'updated_by', 'updated_at', 'datafix'], 'integer'],
            [['name', 'name_en', 'name_py'], 'string', 'max' => 50],
            [['name'], 'required'],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'name_en' => '名称英文',
            'name_py' => '名称拼音',
            'created_by' => '创建人',
            'created_at' => '创建时间',
            'updated_by' => '更新人',
            'updated_at' => '更新时间',
            'datafix' => '标记',
        ];
    }
    public static function loadAllProductSkin(){
        return self::getAll('id,name', ['datafix'=>self::DATAFIX]);
    }
}
