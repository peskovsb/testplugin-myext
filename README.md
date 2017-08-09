My ext
======
My ext

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist myext/yii2-myext "*"
```

or add

```
"myext/yii2-myext": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \myext\upl\AutoloadExample::widget(); ?>```