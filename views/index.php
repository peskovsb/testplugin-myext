<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\bootstrap\ActiveForm;

\myext\upl\modules\uploads\assets\UploadAsset::register($this);
?>

<div id="files-photo_id">
    <ul class="upload-files">
    </ul>
</div>

<div class="upload" id="upload-photo_id" data-route="/uploads/search/manuf" data-callback="" data-object-id="1" data-field-id="4">
    <div class="drop">
        Перетащите изображение в эту область <a>или&nbsp;выберите с&nbsp;локального&nbsp;диска</a>
    </div>
    <ul></ul>
</div>