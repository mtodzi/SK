<?php

namespace backend\modules\clients;

/**
 * clients module definition class
 */
class Clients extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\clients\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->defaultRoute = 'client';
        // custom initialization code goes here
    }
}
