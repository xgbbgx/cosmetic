<?php

namespace common\models\category;

use Yii;

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
}
