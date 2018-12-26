<?php
namespace common\models\elastic;

use yii\elasticsearch\ActiveRecord;

class EsStore extends ActiveRecord {
    
    /**
     * @return array the list of attributes for this record
     */
    public function attributes() {
        // path mapping for '_id' is setup to field 'id'
        return ['id', 'name','keyword','desc'];
    }
}