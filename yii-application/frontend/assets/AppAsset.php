<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@vendor/twbs';
    public $css = [        
        'bootstrap\dist\css\bootstrap.min.css',
    ];
    public $js = [
        'bootstrap\dist\js\bootstrap.bundle.min.js',
  
    ];
    public $depends = [
        'frontend\assets\AppAssetJquery',     
    ];
}
