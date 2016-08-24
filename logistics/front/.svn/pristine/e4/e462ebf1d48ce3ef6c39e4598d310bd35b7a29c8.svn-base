<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "postal_matrix_static".
 *
 * @property integer $id
 * @property string $from
 * @property string $to
 * @property integer $time
 * @property string $modified
 * @property string $from_zone
 * @property string $to_zone
 */
class PostalMatrixStatic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'postal_matrix_static';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from', 'to', 'time', 'modified', 'from_zone', 'to_zone'], 'required'],
            [['time'], 'integer'],
            [['modified'], 'safe'],
            [['from', 'to'], 'string', 'max' => 6],
            [['from_zone', 'to_zone'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from' => 'From',
            'to' => 'To',
            'time' => 'Time',
            'modified' => 'Modified',
            'from_zone' => 'From Zone',
            'to_zone' => 'To Zone',
        ];
    }
    
    public function beforeSave($insert){
    	$this->from_zone = substr($this->from, 0,2);
    	$this->to_zone = substr($this->to, 0,2);
    	return parent::beforeSave($insert);
    }
}
