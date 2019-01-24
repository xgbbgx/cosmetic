<?php

namespace common\models\product;

use Yii;

/**
 * This is the model class for table "{{%product_currency}}".
 *
 * @property int $id ID
 * @property string $name 功效名称
 * @property string $name_en 功效英文
 * @property string $name_py 功效拼音
 * @property string $symbol 符号
 * @property int $created_by
 * @property int $created_at
 * @property int $updated_by
 * @property int $updated_at
 * @property int $datafix 0正常1删除
 */
class ProductCurrency extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_currency}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_by', 'created_at', 'updated_by', 'updated_at', 'datafix'], 'integer'],
            [['name', 'name_en', 'name_py', 'symbol'], 'string', 'max' => 50],
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
            'name' => '币种名称',
            'name_en' => '币种英文',
            'name_py' => '币种拼音',
            'symbol' => '符号',
            'created_by' => '创建人',
            'created_at' => '创建时间',
            'updated_by' => '更新人',
            'updated_at' => '更新时间',
            'datafix' => '标记',
        ];
    }
}
