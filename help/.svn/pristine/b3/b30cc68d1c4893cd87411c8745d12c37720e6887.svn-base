<?php
class ImageUtils {
	public static function resize( $source_path,$target_path,$target_width,$target_height,$strict=FALSE)
	{
		list( $source_width, $image_height, $source_type ) = getimagesize( $source_path );

		switch ( $source_type )
		{
			case IMAGETYPE_GIF:
				$source_image = imagecreatefromgif( $source_path );
				break;

			case IMAGETYPE_JPEG:
				$source_image = imagecreatefromjpeg( $source_path );
				break;

			case IMAGETYPE_PNG:
				$source_image = imagecreatefrompng( $source_path );
				break;
			default:
				return false;
		}

		if ( $source_image === false )
		{
			return false;
		}

		if(!$strict && $image_height<$target_height && $source_width < $target_height && $source_path==$target_path){
			if($source_type==IMAGETYPE_JPEG){
				return true;
			}
			$target_width = $source_width;
			$target_height = $image_height;
		}else{
			$source_aspect_ratio = $source_width / $image_height;
			$target_aspect_ratio = $target_width / $target_height;
			if ( $target_aspect_ratio > $source_aspect_ratio ){
				$target_width = ( int ) ( $target_height * $source_aspect_ratio );
			}else{
				$target_height = ( int ) ( $target_width / $source_aspect_ratio );
			}
		}

		$target_image = imagecreatetruecolor( $target_width, $target_height );
		imagealphablending($target_image, false);
		imagesavealpha($target_image, true);
		imagealphablending($source_image, true);
		imagecopyresampled($target_image, $source_image, 0, 0, 0, 0, $target_width, $target_height, $source_width, $image_height);
		imagejpeg($target_image,$target_path,95);
		imagedestroy($target_image);
		imagedestroy($source_image);
		return true;
	}
}

?>