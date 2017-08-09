<?php

namespace myext\upl\assets;

use yii\web\AssetBundle;

class UploadAsset extends AssetBundle
{
    public $sourcePath = '@myext/upl/assets/upload';

    public $js = [
        'http://code.jquery.com/ui/1.12.1/jquery-ui.min.js',
        'js/jquery.iframe-transport.js',
        'js/jquery.fileupload.js',
        'js/upload.js',
    ];

    public $css = [
        'css/upload.css',
    ];

    public $depends = [
        'app\assets\AppAsset',
        'myext\upl\assets\JqueryKnobAsset',
    ];
}