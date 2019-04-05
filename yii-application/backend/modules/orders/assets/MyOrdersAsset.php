<?php

namespace backend\modules\orders\assets;

use yii\web\AssetBundle;
use backend\assets\AppAssetJquery;
use backend\assets\AppAsset;

/**
 * Main backend application asset bundle.
 */
class MyOrdersAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'm_orders/css/orders.css',
    ];
    public $js = [
        'm_orders/js/jquery.maskedinput.min.js',
        'm_orders/js/pdfmake.min.js',        
        'm_orders/js/vfs_fonts.js',
        'm_orders/js/orders.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
        'backend\assets\AppAssetJquery',
    ];
}
