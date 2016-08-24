<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "driver".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property double $lat
 * @property double $lng
 */
class BelongToUser extends \yii\db\ActiveRecord
{

	public function beforeValidate(){
		if ($this->isNewRecord && empty($this->user_id)){
			$this->user_id = Yii::$app->user->id;
		}
		return parent::beforeValidate();
	}

    public function getUser()
    {
        $user = Yii::$app->getModule("user")->model("User");
        return $this->hasOne($user::className(), ['id' => 'user_id']);
    }

}
