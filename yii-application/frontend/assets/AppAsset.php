<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@vendor';
    public $css = [        
        'twbs/bootstrap/dist/css/bootstrap.min.css',
    ];
    public $js = [
        'twbs/bootstrap/dist/js/bootstrap.bundle.min.js',
  
    ];
    public $depends = [
        'frontend\assets\AppAssetJquery',     
    ];
}
