<?php
namespace backend\assets;

use yii\web\AssetBundle;
/**
 * 
 * @author lgl
 * @desc 弹窗组件配置
 *
 */
class UniformAsset extends AssetBundle
{
	public $css = [
	    'css/metronic/uniform.default.css',
	    'css/metronic/select2_metro.css',
	    'css/metronic/chosen.css',
	    'css/metronic/datepicker.css',
	   // 'css/metronic/bootstrap-modal.css'
	];

	public $js = [
		'js/metronic/select2.min.js',
	    'js/jquery/jquery.uniform.min.js',
	    'js/jquery/chosen.jquery.min.js',
	    'js/metronic/date.js',
	    'js/metronic/bootstrap-datepicker.js',
	    //'js/metronic/bootstrap-modal.js',
	    //'js/metronic/bootstrap-modalmanager.js',
	];
	public $jsOptions = [
	   // 'position' => \yii\web\View::POS_HEAD
	];
	public $depends = [
	    'backend\assets\AppAsset'
	];
}