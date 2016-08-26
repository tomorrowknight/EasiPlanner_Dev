<?php

namespace chief725\models;

use Yii;

/**
 * This is the model class for table "favorite".
 *
 * @property integer $id
 * @property string $user_id
 * @property integer $node_id
 */
class Favorite extends Follow
{
	public static $follower_id = "user_id";
	public static $followee_id = "node_id";
	
	public static function tableName()
	{
		return 'favorite';
	}
}
