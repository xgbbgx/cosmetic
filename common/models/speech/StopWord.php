<?php

namespace common\models\speech;

use Yii;

/**
 * This is the model class for table "{{%stop_word}}".
 *
 * @property string $id
 * @property string $name 噪词词组
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $datafix 0正常1删除
 */
class StopWord extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stop_word}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'datafix'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'datafix' => 'Datafix',
        ];
    }
    /**
     * 查询燥词
     * @param unknown $names
     * @return array
     */
    public static function loadStopWordByNames($names){
        $query = (new \yii\db\Query())
        ->select('name')
        ->from(self::tableName())
        ->where(['datafix'=>self::DATAFIX]);
        $query->andWhere(['in','name',$names]);
        return $query->column();
    }
}
