<?php

namespace backend\modules\acsess\models;

/**
 * This is the ActiveQuery class for [[Acsess]].
 *
 * @see Acsess
 */
class AcsessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Acsess[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Acsess|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
