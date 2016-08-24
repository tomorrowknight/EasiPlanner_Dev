<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "traveltime".
 *
 * @property integer $TravelTimeID
 * @property string $Name
 * @property integer $Direction
 * @property string $FarEndPoint
 * @property string $StartPoint
 * @property string $EndPoint
 * @property integer $EstimatedTime
 * @property string $CreateDate
 */
class Traveltime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'traveltime';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[["TravelTimeID"],'unique'],
            [['TravelTimeID', 'Name', 'Direction', 'FarEndPoint', 'StartPoint', 'EndPoint', 'EstimatedTime', 'CreateDate'], 'required'],
            [['TravelTimeID', 'Direction', 'EstimatedTime'], 'integer'],
            [['CreateDate'], 'safe'],
            [['Name', 'FarEndPoint', 'StartPoint', 'EndPoint'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TravelTimeID' => 'Travel Time ID',
            'Name' => 'Name',
            'Direction' => 'Direction',
            'FarEndPoint' => 'Far End Point',
            'StartPoint' => 'Start Point',
            'EndPoint' => 'End Point',
            'EstimatedTime' => 'Estimated Time',
            'CreateDate' => 'Create Date',
        ];
    }
}
