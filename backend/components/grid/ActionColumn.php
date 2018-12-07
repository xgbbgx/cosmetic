<?php 
namespace backend\components\grid;

use Yii;
use yii\helpers\Html;

class ActionColumn{
    
    public $template='{view}&nbsp;&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;{delete}';
    public $buttonOptions = [];
    public $buttons = [];
    
    function renderDataCellContent()
    {
        $str='';
        if($this->buttons){
            foreach ($this->buttons as $button){
                if($button['name']=='view'){
                    $str .=$this->initDefaultButton('view', 'eye-open',$button['url']);
                }else if($button['name']=='update'){
                    $str .= $this->initDefaultButton('update', 'pencil',$button['url']);
                }else if($button['name']=='delete'){
                    $str .=$this->initDefaultButton('delete', 'trash',$button['url'], [
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                    ]);
                }
            }
        }
        return $str;
    }
    /**
     *
     * @param unknown $name
     * @param unknown $iconName
     * @param unknown $url
     * @param array $additionalOptions
     * @param array $buttonOptions
     * @return string
     */
    protected function initDefaultButton($name, $iconName,$url, $additionalOptions = [])
    {
        switch ($name) {
            case 'view':
                $title = Yii::t('yii', 'View');
                break;
            case 'update':
                $title = Yii::t('yii', 'Update');
                break;
            case 'delete':
                $title = Yii::t('yii', 'Delete');
                break;
            default:
                $title = ucfirst($name);
        }
        $options = array_merge([
            'title' => $title,
            'aria-label' => $title,
            'data-pjax' => '0',
        ], $additionalOptions, $this->buttonOptions);
        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
        return Html::a($icon, $url, $options);
    }
}

?>