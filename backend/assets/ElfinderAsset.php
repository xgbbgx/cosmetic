<?php
namespace backend\assets;

use yii\web\AssetBundle;
/**
 * 
 * @author lgl
 * @desc 
 *
 */
class ElfinderAsset extends AssetBundle
{
	public $css = [
	    'css/jquery-ui-1.8.21.custom.css',
	    'css/elfinder/elfinder.min.css',
	    'css/elfinder/elfinder.theme.css',
	];

	public $js = [
	    'js/jquery/jquery-1.7.2.min.js',
	    'js/jquery/jquery-ui-1.10.1.custom.min.js',
	    'js/jquery/jquery.elfinder.min.js'
	];
	public $jsOptions = [
	    'position' => \yii\web\View::POS_HEAD
	];
	public $depends = [
	    //'backend\assets\AppAsset'
	];
}