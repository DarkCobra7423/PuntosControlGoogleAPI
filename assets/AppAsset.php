<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    //public $home = Yii::$app->homeUrl;

    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/jquery.js',        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];

    public function init()
    {
        parent::init();

        // Concatena valores dinámicos a la propiedad $js
        $this->js[] = 'js/script.js?homeurl=' . Yii::$app->homeUrl . '&csrf='.Yii::$app->request->csrfToken;//Se incluye el script que contiene las funciones solicitadas en los requisitos
    }
}
