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
 * This is an AssetBundle that is specific to the the yii2-sii-file-mgr
 * Which displays our projects in a nice tile format.
 */
class SiiAsset extends AssetBundle
{
    public $sourcePath = '@app/assets';
    public $basePath = null;
    public $baseUrl = null;

    public $css = [
        'yii2-sii-file-mgr.css'
    ];
    public $js = [
    ];
    public $depends = [
        'backend\assets\W3schoolsAsset',
    ];
}
