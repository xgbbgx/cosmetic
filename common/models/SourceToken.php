<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%source_token}}".
 *
 * @property int $id ID
 * @property string $token 外部token
 * @property int $expire_time 有效时间
 * @property int $created_at
 * @property int $created_by
 * @property int $source_id 1阿里翻译token
 */
class SourceToken extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%source_token}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['expire_time', 'created_at', 'created_by', 'source_id'], 'integer'],
            [['token'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'expire_time' => 'Expire Time',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'source_id' => 'Source ID',
        ];
    }
    /**
     * 获取 有效期内的token
     * @param unknown $sourceId
     * @return array|boolean
     */
    public static function loadExpiredTokenBySourceId($sourceId){
        $query = (new \yii\db\Query())
        ->select('token,expire_time')
        ->from(self::tableName())
        ->where(['source_id'=>$sourceId]);
        $query->andWhere(['>','expire_time',time()]);
        $query->orderBy(['expire_time'=>SORT_DESC]);
        return $query->one();
    }
}
