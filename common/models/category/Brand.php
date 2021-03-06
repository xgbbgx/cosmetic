<?php

namespace common\models\category;


/**
 * This is the model class for table "{{%brand}}".
 *
 * @property int $id
 * @property string $name 品牌名称
 * @property string $name_en 品牌英文名
 * @property string $name_py 品牌拼音
 * @property string $logo 品牌logo
 * @property int $type 类别101欧美品牌102日韩品牌103国产品牌
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $datafix 0:正常1删除
 */
class Brand extends \common\core\common\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%brand}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            ['type','in','range'=>['101','102','103']],
            [['type', 'created_at', 'created_by', 'updated_at', 'updated_by', 'datafix'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name_en', 'name_py'], 'string', 'max' => 100],
            [['logo'], 'string', 'max' => 500],
            [['name','type'], 'unique', 'targetAttribute' => ['name', 'type']]
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
            'logo' => 'Logo',
            'type' => 'Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'datafix' => 'Datafix',
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
            $sql='select id,name,name_en,name_py,logo,type from '.
                self::tableName().' '.$where.' '.$order.' '.@$arr['sLimit'];;
            $data['list']=self::findBySql($sql)->asArray()->all();
        }
        $data['totalNum']=empty($totalNum) ?0:$totalNum;
       return $data;
    }
    public static function loadBrandById($id){
        return self::getOne('id,name,name_en,name_py ',['id'=>$id]);
    }
    public static function loadSearchNameByNameLike($name,$limit=10){
        return self::find()->select(['id','name','name_en','name_py'])->where([
            'datafix'=>self::DATAFIX,
        ])->andwhere([
            'or',
            ['like','name',$name.'%',false],
            ['like','name_en',$name.'%',false],
            ['like','name_py',$name.'%',false],
        ])->orderBy(['name'=>SORT_ASC])->limit($limit)->asArray()->all();
    }
}
