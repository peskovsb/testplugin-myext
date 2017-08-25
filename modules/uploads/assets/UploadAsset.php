<?php

namespace myext\upl\modules\uploads\assets;

use yii\web\AssetBundle;

class UploadAsset extends AssetBundle
{
    public $sourcePath = '@myext/upl/modules/uploads/assets/upload';

    public $js = [
        'http://code.jquery.com/ui/1.12.1/jquery-ui.min.js',
        'js/jquery.iframe-transport.js',
        'js/jquery.fileupload.js',
        'js/upload.js',
        'js/jquery.knob.min.js',
    ];

    public $css = [
        'css/upload.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}