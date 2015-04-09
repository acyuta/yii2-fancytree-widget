<?php
/**
 * @link      https://github.com/acyuta/yii2-fancytree-widget
 * @copyright Copyright (c) 2014 Wanderson Bragança
 * @license   https://github.com/acyuta/yii2-fancytree-widget/blob/master/LICENSE
 */

namespace acyuta\fancytree;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * The yii2-fancytree-widget is a Yii 2 wrapper for the fancytree.js
 * See more: https://github.com/mar10/fancytree
 *
 * @author Wanderson Bragança <wanderson.wbc@gmail.com>
 * @author Glushkov Akim <acyuta.lpt@gmail.com>
 */
class FancytreeWidget extends \yii\base\Widget
{
    /**
     * @var array
     */
    public $options = [];

    /**
     * @var string
     */
    public $focusOnKey = null;

    /**
     * @var JsExpression
     */
    public $afterLoad = null;
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        FancytreeAsset::register($view);
        $id = 'fancytree_' . $this->id;
        if (isset($this->options['id'])) {
            $id = $this->options['id'];
            unset($this->options['id']);
        } else {
           echo Html::tag('div', '', ['id' => $id]);
        }
        $options = Json::encode($this->options);
        $view->registerJs('$("#' . $id . '").fancytree( ' .$options .');');
        if (isset($this->focusOnKey))
            $view->registerJs('$("#' . $id . '").fancytree("getTree").activateKey("' . $this->focusOnKey . '");');
        if (isset($this->afterLoad))
            $view->registerJs($this->afterLoad->expression);

    }
}
