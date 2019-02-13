<?php

namespace frontend\assets;

use yii\web\AssetBundle;


/**
 * Main backend application asset bundle.
 */
class AppAssetJquery extends AssetBundle
{
    public $sourcePath = '@vendor';
    public $css = [    
    ];
    public $js = [
        'components/jquery/jquery.min.js',
    ];
    public $depends = [       
    ];
}
