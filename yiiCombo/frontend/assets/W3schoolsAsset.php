<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
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
        'frontend\assets\AppAsset',
    ];
}
