<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Center of Excellence for Bioinformatics Research
 * This is an AssetBundle that sets up the W3 CSS
 */
class W3schoolsAsset extends AssetBundle
{
    public $sourcePath = '@app/assets';
    public $basePath = null;
    public $baseUrl = null;

    public $css = [
        'w3.css',
    ];
    public $js = [
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
