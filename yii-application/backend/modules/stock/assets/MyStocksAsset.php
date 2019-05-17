<?php

namespace backend\modules\stock\assets;

use yii\web\AssetBundle;
use backend\assets\AppAssetJquery;
use backend\assets\AppAsset;

/**
 * Main backend application asset bundle.
 */
class MyStocksAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'm_stocks/css/stocks.css',
    ];
    public $js = [
        'm_stocks/js/jquery.maskedinput.min.js',
        'm_stocks/js/stocks.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
        'backend\assets\AppAssetJquery',
    ];
}
