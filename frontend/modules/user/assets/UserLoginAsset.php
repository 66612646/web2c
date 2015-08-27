<?php
namespace frontend\modules\user\assets;

use yii\web\AssetBundle;

class UserAsset extends AssetBundle
{
    public $sourcePath = '@frontend/modules/user/web';
    public $css = [
        'css/metisMenu.min.css',
        'css/sb-admin-2.css',
        //'css/font-awesome.min.css',
    ];
    public $js = [
        'js/metisMenu.min.js',
        'js/sb-admin-2.js'
    ];
    public $depends = [
        //'frontend\assets\AppAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
