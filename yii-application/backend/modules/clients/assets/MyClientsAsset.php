<?php

namespace backend\modules\clients\assets;

use yii\web\AssetBundle;
use backend\assets\AppAssetJquery;
use backend\assets\AppAsset;

/**
 * Main backend application asset bundle.
 */
class MyClientsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'm_clients/css/clients.css',
    ];
    public $js = [
        'm_clients/js/clients.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
        'backend\assets\AppAssetJquery',
    ];
}
