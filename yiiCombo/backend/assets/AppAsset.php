<?php
namespace backend\assets;
use yii\web\AssetBundle;
/**
 * Main backend application asset bundle.
 * This handles the main css bundle coming from bootstrap
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = ['css/site.css',
    ];
    public $js = [ 'js/bootbox.min.js', 'js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
