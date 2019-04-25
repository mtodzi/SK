<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@vendor/twbs';
    //public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        //'../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css',
        'bootstrap/dist/css/bootstrap.min.css',
    ];
    public $js = [
        'bootstrap/dist/js/bootstrap.bundle.min.js',
  
    ];
    public $depends = [
        'backend\assets\AppAssetJquery',     
    ];
}
