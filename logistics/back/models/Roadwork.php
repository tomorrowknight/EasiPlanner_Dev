<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roadwork".
 *
 * @property integer $RoadWorkID
 * @property string $RoadID
 * @property string $Type
 * @property string $StartDate
 * @property string $EndDate
 * @property string $RoadName
 * @property string $CreateDate
 */
class Roadwork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'roadwork';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[["RoadWorkID"],'unique'],
            [['RoadWorkID', 'RoadID', 'Type', 'StartDate', 'EndDate', 'RoadName', 'CreateDate'], 'required'],
            [['RoadWorkID'], 'integer'],
            [['StartDate', 'EndDate', 'CreateDate'], 'safe'],
            [['RoadID', 'Type'], 'string', 'max' => 111],
            [['RoadName'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'RoadWorkID' => 'Road Work ID',
            'RoadID' => 'Road ID',
            'Type' => 'Type',
            'StartDate' => 'Start Date',
            'EndDate' => 'End Date',
            'RoadName' => 'Road Name',
            'CreateDate' => 'Create Date',
        ];
    }
}
