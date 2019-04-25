<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AssetKartikFileInput extends AssetBundle
{
    public $sourcePath = '@vendor/kartik-v';
    public $css = [
        'bootstrap-fileinput/css/fileinput.min.css',
    ];
    public $js = [
                
        'bootstrap-fileinput/js/plugins/piexif.min.js',
        'bootstrap-fileinput/js/plugins/purify.min.js',
        'bootstrap-fileinput/js/plugins/sortable.min.js',
        'bootstrap-fileinput/js/fileinput.min.js',
        'bootstrap-fileinput/themes/fas/theme.min.js',
        'bootstrap-fileinput/js/locales/LANG.js',
        'bootstrap-fileinput/js/locales/ru.js',
       
        
  
    ];
    public $depends = [
        'backend\assets\AppAsset',
        'backend\assets\AppAssetJquery',
        
    ];
}
