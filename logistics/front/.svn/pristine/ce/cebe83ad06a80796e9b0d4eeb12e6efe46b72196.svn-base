<?php

namespace chief725\models;

use yii\web\UploadedFile;

use yii\base\Exception;

use chief725\libs\ImageUtils;

use yii\helpers\Url;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property integer $recipe_id
 */
class Image extends BaseRecord
{
	const RESIZE_CENTER_CROP  = 0;
	const RESIZE_CENTER_INSIDE = 1;
	const RESIZE_NORMAL = 2;

	private $info;
	 
	public static function tableName()
	{
		return 'image';
	}
	public function getImagePath(){
		return Yii::getAlias("@webroot/images/".static::tableName()."/$this->id.jpg");
	}

	public function getImageUrl(){
		if (!file_exists($this->getImagePath())){
			return Url::to("@web/images/default/".static::tableName().".jpg",true);
		}
		return Url::to("@web/images/".static::tableName()."/$this->id.jpg",true);
	}
	public function getImageHtml($options=[]){
		return Html::img($this->getImageUrl(),$options);
	}
	
	public static function getImageDefaultUrl(){
		return Url::to("@web/images/default/".static::tableName().".jpg",true);
	}

	public function afterDelete(){
		$this->checkAccess();
		$this->removeImage();
		parent::afterDelete();
	}

	public function isThere() {
		return file_exists($this->getImagePath()) && filesize($this->getImagePath()) > 0 ;
	}
	
	public function removeImage(){
		@unlink($this->getImagePath());
	}

	public function resize($width,$height,$resizeType=self::RESIZE_NORMAL,$imageType="jpeg"){
		$imageData = $this->cut($width, $height, $resizeType);
		if($imageData == false){
			return false;
		}
		if ($imageType == "jpeg"){
			imagejpeg($imageData,$this->getImagePath(),100);
		}elseif ($imageType == "png"){
			imagepng($imageData,$this->getImagePath(),5);
		}else{
			return false;
		}
	}

	public function getResizeUrl($width,$height,$resizeType=self::RESIZE_NORMAL,$imageType="jpeg"){
		return Url::to(['site/image','class'=>str_replace("\\", ".", static::className()),"id"=>$this->id,'width'=>$width,'height'=>$height,'resizeType'=>$resizeType,'imageType'=>$imageType,'v'=>$this->isThere()?fileatime($this->getImagePath()):null],true);
	}

	public function getInfo(){
		if (!empty($this->info)){
			return $this->info;
		}
		return  getimagesize($this->getImagePath());
	}


	public function cut($target_width,$target_height,$type){
		if (!$this->isThere()){
			return false;
		}
		list( $source_width, $source_height, $source_type ) = $this->getInfo();
		
		if ($source_type == IMAGETYPE_GIF){
			$source_image = imagecreatefromgif($this->getImagePath());
		}elseif ($source_type == IMAGETYPE_JPEG){
			$source_image = imagecreatefromjpeg($this->getImagePath());
		}elseif ($source_type == IMAGETYPE_PNG){
			$source_image = imagecreatefrompng($this->getImagePath());
		}
		if (empty($source_image)){
			return false;
		}
		
		$source_x = 0;
		$source_y = 0;
		if ($type == self::RESIZE_CENTER_CROP){
			$source_aspect_ratio = $source_width / $source_height;
			$target_aspect_ratio = $target_width / $target_height;
			if ( $target_aspect_ratio > $source_aspect_ratio ){
				$source_width = $source_width;
				$source_height = (int)($source_width/$target_aspect_ratio);
				$source_y = ($source_height-$source_height)/2;
			}else{
				$source_height = $source_height;
				$source_width = (int)($source_height*$target_aspect_ratio);
				$source_x = ($source_width-$source_width)/2;
			}
		}else{
			if($type==self::RESIZE_NORMAL && $source_width<$target_width && $source_height < $target_height){
				$target_width = $source_width;
				$target_height = $source_height;
			}else{
				$source_aspect_ratio = $source_width / $source_height;
				$target_aspect_ratio = $target_width / $target_height;
				if ( $target_aspect_ratio > $source_aspect_ratio ){
					$target_width = ( int ) ( $target_height * $source_aspect_ratio );
				}else{
					$target_height = ( int ) ( $target_width / $source_aspect_ratio );
				}
			}
		}

		$target_image = imagecreatetruecolor($target_width, $target_height);
		imagealphablending($target_image, false);
		imagesavealpha($target_image, true);
		imagealphablending($source_image, true);
		imagecopyresampled($target_image, $source_image, 0, 0, $source_x,$source_y, $target_width, $target_height, $source_width, $source_height);
		imagedestroy($source_image);
		return $target_image;
	}
	
	public function upload($uploadedFile,$width=800,$height=800,$type=self::RESIZE_NORMAL){
		if(empty($uploadedFile)){
			return false;
		}
		
		if (is_string($uploadedFile)){
			$uploadedFile = @file_get_contents($uploadedFile);
			if (empty($uploadedFile)){
				return false;
			}
		}
		
		if ($uploadedFile instanceof  UploadedFile){
			$uploadedFile->saveAs($this->getImagePath());
		}else{
			file_put_contents($this->getImagePath(), $uploadedFile);
		}
		if($this->resize($width, $height,$type)){
			$this->delete();
			return false;
		}
		return $this->getUrl();
	}
	
	public function getNode(){
		return $this::hasOne(Node::className(), ["id"=>"node_id"]);
	}
}
