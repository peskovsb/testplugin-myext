<?php

namespace myext\upl\assets;

use yii\web\AssetBundle;

class JqueryKnobAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/jquery-knob/dist';

    public $js = [
        'jquery.knob.min.js'
    ];

    public $css = [
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}