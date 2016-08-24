<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "weather".
 *
 * @property integer $id
 * @property string $area
 * @property string $description
 * @property string $created
 */
class Weather extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'weather';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area', 'description', 'created'], 'required'],
            [['created'], 'safe'],
            [['area', 'description'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'area' => 'Area',
            'description' => 'Description',
            'created' => 'Created',
        ];
    }
}
