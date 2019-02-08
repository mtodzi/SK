<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AssetKartikFileInput extends AssetBundle
{
    public $sourcePath = '@vendor';
    public $css = [
        'kartik-v/bootstrap-fileinput/css/fileinput.min.css',
    ];
    public $js = [
                
        'kartik-v/bootstrap-fileinput/js/plugins/piexif.min.js',
        'kartik-v/bootstrap-fileinput/js/plugins/purify.min.js',
        'kartik-v/bootstrap-fileinput/js/plugins/sortable.min.js',
        'kartik-v/bootstrap-fileinput/js/fileinput.min.js',
        'kartik-v/bootstrap-fileinput/themes/fas/theme.min.js',
        'kartik-v/bootstrap-fileinput/js/locales/LANG.js',
        'kartik-v/bootstrap-fileinput/js/locales/ru.js',
       
        
  
    ];
    public $depends = [
        'backend\assets\AppAsset',
        'backend\assets\AppAssetJquery',
        
    ];
}
