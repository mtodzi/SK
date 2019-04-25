<?php

namespace backend\assets;

use yii\web\AssetBundle;


/**
 * Main backend application asset bundle.
 */
class AppAssetJquery extends AssetBundle
{
    public $sourcePath = '@vendor/components';
    public $css = [    
    ];
    public $js = [
        'jquery/jquery.min.js',
    ];
    public $depends = [       
    ];
}
