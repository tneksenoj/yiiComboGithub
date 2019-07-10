<?php

namespace backend\assets;

use yii\web\AssetBundle;

/*
 * Imports fonts from Google Fonts. 
 */

class FontAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//fonts.googleapis.com/css?family=IBM+Plex+Sans:400,700',
        '//fonts.googleapis.com/css?family=IBM+Plex+Sans+Condensed:400,700',
        '//fonts.googleapis.com/css?family=IBM+Plex+Serif:400,700',
    ];
    public $cssOptions = [
        'type' => 'text/css',
    ];
}