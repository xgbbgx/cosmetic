<?php

namespace common\models\classify;

use Yii;

/**
 * This is the model class for table "{{%classify_attr_val}}".
 *
 * @property int $id ID
 * @property string $name 分类属性名称
 * @property string $name_en 分类属性英文
 * @property string $name_py 分类属性拼音
 * @property int $classify_attr_id 分类属性ID
 * @property int $datafix 0正常1删除
 */
class ClassifyAttrVal extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%classify_attr_val}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['classify_attr_id','datafix'], 'integer'],
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
            'name' => '属性名称值',
            'name_en' => '属性值英文',
            'name_py' => '属性值拼音',
            'classify_attr_id' => '分类属性ID',
            'datafix' => 'Datafix',
        ];
    }
}
