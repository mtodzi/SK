<?php

namespace backend\modules\developer\models;

/**
 * This is the ActiveQuery class for [[Controler]].
 *
 * @see Controler
 */
class ControlerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Controler[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Controler|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
