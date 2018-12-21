<?php

namespace common\models\speech;

use Yii;

/**
 * This is the model class for table "{{%speech_flow}}".
 *
 * @property int $id 语音ID
 * @property string $code 生成md5唯一码
 * @property string $dst_name 目标名称
 * @property string $dst_url 地址
 * @property int $size 大小B
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $datafix 0正常1删除
 */
class SpeechFlow extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%speech_flow}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['size', 'created_at', 'created_by', 'updated_at', 'updated_by', 'datafix'], 'integer'],
            [['code'], 'string', 'max' => 32],
            [['dst_name'], 'string', 'max' => 50],
            [['dst_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'dst_name' => 'Dst Name',
            'dst_url' => 'Dst Url',
            'size' => 'Size',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'datafix' => 'Datafix',
        ];
    }
}
