<?php

namespace backend\modules\developer\models;

/**
 * This is the ActiveQuery class for [[ActionCt]].
 *
 * @see ActionCt
 */
class ActionCtQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ActionCt[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ActionCt|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
