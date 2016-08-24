<?php

namespace app\models;

use chief725\libs\Log;

use chief725\models\BaseRecord;

use Yii;

/**
 * This is the model class for table "geocode".
 *
 * @property integer $id
 * @property string $postal
 * @property double $lat
 * @property double $lng
 * @property string $modified
 */
class Geocode extends BaseRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geocode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['postal', 'lat', 'lng'], 'required'],
            [['lat', 'lng'], 'number'],
            [['modified'], 'safe'],
            [['postal'], 'string', 'max' => 6],
            [['postal'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'postal' => 'Postal',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'modified' => 'Modified',
        ];
    }
    public static function findGeocode($postal){
    	return  self::findOne(['postal'=>$postal]);
    }
    public static function updateGeocode($postal,$lat,$lng){
    	if ($lat < 1.2 || $lat > 1.6 || $lng < 100 || $lng > 110){
    		Log::info("Invalid lat,lng  - $lat ,$lng");
    		return;
    	}
    	$geocode = self::findGeocode($postal);
    	if(empty($geocode)){
    		$geocode = new Geocode();
    		$geocode->postal = $postal;
    	}

    	if ($geocode->isNewRecord || time() - strtotime($geocode->modified) > 3600*24*30){
    		$geocode->lat = $lat;
    		$geocode->lng = $lng;
    		$geocode->modified = date("Y-m-d H:i:s");
    	}
    	if(!$geocode->save(false)){
    		print_r($geocode->getErrors());
    	}
    }

    public static function guessGeocode($postal){
    	foreach (range(5, 2) as $length){
    		$match = substr($postal, 0, $length)."%";
    		$lat = Geocode::find()->where(['like',"postal",$match,false])->average("lat");
    		$lng = Geocode::find()->where(['like',"postal",$match,false])->average("lng");
    		if (!empty($lat)){
    			return ['lat'=>$lat,'lng'=>$lng];
    		}
    	}
    }
}
