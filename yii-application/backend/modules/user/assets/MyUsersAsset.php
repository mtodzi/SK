<?php

namespace backend\modules\user\assets;

use yii\web\AssetBundle;
use backend\assets\AppAssetJquery;
use backend\assets\AppAsset;

/**
 * Main backend application asset bundle.
 */
class MyUsersAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'users/css/layoutsSite.css',
    ];
    public $js = [
        'users/js/jquery.maskedinput.min.js',
        'users/js/user.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
        'backend\assets\AppAssetJquery',
    ];
}
