<?php

namespace common\models\speech;

use Yii;

/**
 * This is the model class for table "{{%speech_arc}}".
 *
 * @property int $id 语音ID
 * @property int $speech_flow_id 待翻译流水id号
 * @property string $dst_url 地址
 * @property int $type 1:百度翻译，2阿里翻译
 * @property string $content 翻译内容
 * @property string $split_word 分割内容以逗号区分
 * @property string $exact_word 去噪最终分词
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $status 0未处理1已处理
 * @property int $datafix 0正常1删除
 */
class SpeechArc extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%speech_arc}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['speech_flow_id', 'type','status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'datafix'], 'integer'],
            [['dst_url', 'content', 'split_word', 'exact_word'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'speech_flow_id' => 'Speech Flow ID',
            'dst_url' => 'Dst Url',
            'type' => 'Type',
            'content' => 'Content',
            'split_word' => 'Split Word',
            'exact_word' => 'Exact Word',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'datafix' => 'Datafix',
        ];
    }
}
