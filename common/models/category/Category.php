<?php

namespace common\models\category;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property string $name 分类
 * @property string $name_en 英文名
 * @property string $name_py 名称拼音
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
            [['type', 'created_at', 'created_by', 'updated_at', 'updated_by', 'datafix'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name_en', 'name_py'], 'string', 'max' => 100],
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
            'name' => 'Name',
            'name_en' => 'Name En',
            'name_py' => 'Name Py',
            'type' => 'Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'datafix' => 'Datafix',
        ];
    }
}
