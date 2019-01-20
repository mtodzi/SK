<?php

namespace app\modules\acsess;

/**
 * acsess module definition class
 */
class Acsess extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\acsess\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
         $this->defaultRoute = 'auth';
        // custom initialization code goes here
    }
}
