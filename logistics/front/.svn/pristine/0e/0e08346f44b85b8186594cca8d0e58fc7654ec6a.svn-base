<?

namespace app\models;

class Image extends \chief725\models\Image {
	public static function createImage($parcel_id) {
		$image = new static ();
		$image->parcel_id = $parcel_id;
		$image->save ();
		return $image;
	}
	public function getParcel() {
		return $this::hasOne ( Parcel::className (), [
				"id" => "parcel_id"
		] );
	}
}