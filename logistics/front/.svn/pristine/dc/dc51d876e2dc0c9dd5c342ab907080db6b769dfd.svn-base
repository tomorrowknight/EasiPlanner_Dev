<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Parcel;

/**
 * ParcelSearch represents the model behind the search form about `app\models\Parcel`.
 */
class ParcelSearch extends Parcel {
	public $vehicle;
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [ 
				[ 
						[ 
								'id',
								'user_id',
								'vehicle_id',
								'service_time',
								'status' 
						],
						'integer' 
				],
				[ 
						[ 
								'identifier',
								'address',
								'postal',
								'note',
								'deliver_time',
								'phone',
								'customer_name',
								'window_start',
								'window_end' 
						],
						'safe' 
				],
				[ 
						[ 
								'lat',
								'lng',
								'volume',
								'weight' 
						],
						'number' 
				],
				[ 
						[ 
								'vehicle' 
						],
						'safe' 
				] 
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		// bypass scenarios() implementation in the parent class
		return Model::scenarios ();
	}
	
	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params        	
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params) {
		$query = Parcel::find ()->where ( [ 
				'parcel.user_id' => Yii::$app->user->id 
		] );
		
		$query->joinWith ( [ 
				'vehicle' 
		] );
		
		// $query = Parcel::find();
		$dataProvider = new ActiveDataProvider ( [ 
				'query' => $query,
				'pagination' => [ 
						'pageSize' => 50 
				] 
		] );
		
		$dataProvider->sort->attributes ['vehicle'] = [
				// The tables are the ones our relation are configured to
				// in my case they are prefixed with "tbl_"
				'asc' => [ 
						'vehicle.name' => SORT_ASC 
				],
				'desc' => [ 
						'vehicle.name' => SORT_DESC 
				] 
		];
		
		$this->load ( $params );
		
		if (! $this->validate ()) {
			// uncomment the following line if you do not want to any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
		
		$query->andFilterWhere ( [ 
				'parcel.id' => $this->id,
				'vehicle_id' => $this->vehicle_id,
				'parcel.lat' => $this->lat,
				'parcel.lng' => $this->lng,
				'deliver_time' => $this->deliver_time,
				'status' => $this->status,
				'identifier' => $this->identifier,
				'postal' => $this->postal,
				'phone' => $this->phone 
		] );
		
		$query->andFilterWhere ( [ 
				'like',
				'address',
				$this->address 
		] )->andFilterWhere ( [ 
				'like',
				'note',
				$this->note 
		] )->andFilterWhere ( [ 
				'like',
				'customer_name',
				$this->customer_name 
		] );
		
		$query->andFilterWhere ( [ 
				'>',
				'volume',
				$this->volume 
		] )->andFilterWhere ( [ 
				'>',
				'weight',
				$this->weight 
		] )->andFilterWhere ( [ 
				'>',
				'service_time',
				$this->service_time 
		] )->andFilterWhere ( [ 
				'>',
				'window_start',
				$this->window_start 
		] )->andFilterWhere ( [ 
				'<',
				'window_end',
				$this->window_end 
		] );
		
		$query->andFilterWhere ( [ 
				'like',
				'vehicle.name',
				$this->vehicle 
		] );
		return $dataProvider;
	}
}
