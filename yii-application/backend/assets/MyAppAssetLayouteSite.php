<?php

namespace backend\assets;

use yii\web\AssetBundle;
use backend\assets\AppAssetJquery;

/**
 * Main backend application asset bundle.
 */
class MyAppAssetLayouteSite extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/layoutsSite.css',
    ];
    public $js = [
        'js/js.js',
    ];
    public $depends = [
        'backend\assets\AppAssetJquery',
    ];
}
