<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "incident".
 *
 * @property integer $IncidentID
 * @property double $Latitude
 * @property double $Longitude
 * @property string $Type
 * @property string $CreateDate
 */
class Incident extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'incident';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[["IncidentID"],'unique'],
            [['IncidentID', 'Latitude', 'Longitude', 'Type', 'CreateDate'], 'required'],
            [['IncidentID'], 'integer'],
            [['Latitude', 'Longitude'], 'number'],
            [['CreateDate'], 'safe'],
            [['Type'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IncidentID' => 'Incident ID',
            'Latitude' => 'Latitude',
            'Longitude' => 'Longitude',
            'Type' => 'Type',
            'CreateDate' => 'Create Date',
        ];
    }
}
