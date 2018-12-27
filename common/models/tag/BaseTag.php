<?php

namespace common\models\tag;

use Yii;

/**
 * This is the model class for table "{{%base_tag}}".
 *
 * @property int $id
 * @property string $name 词语
 * @property int $weight 权重
 * @property string $noun 词性
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $datafix 0正常1删除
 * @property int $type 11基本词典12补充词典13未归类的双字词14mmseg的差异词典条15新增词条 101为自定义词典
 */
class BaseTag extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%base_tag}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['weight', 'created_at', 'created_by', 'updated_at', 'updated_by', 'datafix', 'type'], 'integer'],
            [['type','name','noun','weight'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['noun'], 'string', 'max' => 10],
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
            'weight' => 'Weight',
            'noun' => 'Noun',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'datafix' => 'Datafix',
            'type' => 'Type',
        ];
    }
    public static function search($arr){
        $data=[];
        $order=empty($arr['sOrder']) ? ' order by id ':$arr['sOrder'];
        $where = '';
        if(isset($arr['sWhere']) && $arr['sWhere']){
            $where=$arr['sWhere'].' and datafix= '.self::DATAFIX;
        }else{
            $where=' where datafix= '.self::DATAFIX;
        }
        $totalNum=self::findBySql('select count(*) from '.self::tableName().' '.$where)->scalar();
        if($totalNum){
            $sql='select id,name,weight,noun,type from '.
                self::tableName().' '.$where.' '.$order.' '.@$arr['sLimit'];;
                $data['list']=self::findBySql($sql)->asArray()->all();
        }
        $data['totalNum']=empty($totalNum) ?0:$totalNum;
        return $data;
    }
}
