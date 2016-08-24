<?php
namespace chief725\libs;

class ImageUtils {
	public static function readImage($source_path){
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
		return $source_image;
	}

	public static function resize( $source_path,$target_path,$target_width,$target_height,$strict=FALSE)
	{
		list( $source_width, $image_height, $source_type ) = getimagesize( $source_path );

		$source_image = ImageUtils::readImage($source_path);

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

	public static function cut($source_path,$target_width,$target_height,$type){
		list($source_width, $source_height) = getimagesize($source_path);
		$source_image = ImageUtils::readImage($source_path);
		$source_aspect_ratio = $source_width / $source_height;
		$target_aspect_ratio = $target_width / $target_height;
		if ( $target_aspect_ratio > $source_aspect_ratio ){
			$src_w = $source_width;
			$src_h = (int)($source_width/$target_aspect_ratio);
			$src_x = 0;
			$src_y = ($source_height-$src_h)/2/2;
		}else{
			$src_h = $source_height;
			$src_w = (int)($source_height*$target_aspect_ratio);
			$src_y = 0;
			$src_x = ($source_width-$src_w)/2;
		}

		$target_image = imagecreatetruecolor( $target_width, $target_height );
		imagealphablending($target_image, false);
		imagesavealpha($target_image, true);
		if ($source_image){
			imagealphablending($source_image, true);
			imagecopyresampled($target_image, $source_image, 0, 0, $src_x,$src_y, $target_width, $target_height, $src_w, $src_h);
			imagedestroy($source_image);
		}
		return $target_image;
	}

	public static function changeHue(&$image, $angle) {
		if($angle % 360 == 0) return;
		$width = imagesx($image);
		$height = imagesy($image);

		for($x = 0; $x < $width; $x++) {
			for($y = 0; $y < $height; $y++) {
				$rgb = imagecolorat($image, $x, $y);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;
				$alpha = ($rgb & 0x7F000000) >> 24;
				list($h, $s, $l) = self::rgb2hsl($r, $g, $b);
				$h += ($angle%360) / 360;
				if($h > 1) $h--;
				list($r, $g, $b) = self::hsl2rgb($h, $s, $l);
				imagesetpixel($image, $x, $y, imagecolorallocatealpha($image, $r, $g, $b, $alpha));
			}
		}
	}

	public static function rgb2hsl($r, $g, $b) {
		$var_R = ($r / 255);
		$var_G = ($g / 255);
		$var_B = ($b / 255);

		$var_Min = min($var_R, $var_G, $var_B);
		$var_Max = max($var_R, $var_G, $var_B);
		$del_Max = $var_Max - $var_Min;

		$v = $var_Max;

		if ($del_Max == 0) {
			$h = 0;
			$s = 0;
		} else {
			$s = $del_Max / $var_Max;

			$del_R = ( ( ( $var_Max - $var_R ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
			$del_G = ( ( ( $var_Max - $var_G ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
			$del_B = ( ( ( $var_Max - $var_B ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;

			if      ($var_R == $var_Max) $h = $del_B - $del_G;
			else if ($var_G == $var_Max) $h = ( 1 / 3 ) + $del_R - $del_B;
			else if ($var_B == $var_Max) $h = ( 2 / 3 ) + $del_G - $del_R;

			if ($h < 0) $h++;
			if ($h > 1) $h--;
		}

		return array($h, $s, $v);
	}

	public static function hsl2rgb($h, $s, $v) {
		if($s == 0) {
			$r = $g = $B = $v * 255;
		} else {
			$var_H = $h * 6;
			$var_i = floor( $var_H );
			$var_1 = $v * ( 1 - $s );
			$var_2 = $v * ( 1 - $s * ( $var_H - $var_i ) );
			$var_3 = $v * ( 1 - $s * (1 - ( $var_H - $var_i ) ) );

			if       ($var_i == 0) {
				$var_R = $v     ; $var_G = $var_3  ; $var_B = $var_1 ;
			}
			else if  ($var_i == 1) {
				$var_R = $var_2 ; $var_G = $v      ; $var_B = $var_1 ;
			}
			else if  ($var_i == 2) {
				$var_R = $var_1 ; $var_G = $v      ; $var_B = $var_3 ;
			}
			else if  ($var_i == 3) {
				$var_R = $var_1 ; $var_G = $var_2  ; $var_B = $v     ;
			}
			else if  ($var_i == 4) {
				$var_R = $var_3 ; $var_G = $var_1  ; $var_B = $v     ;
			}
			else                   { $var_R = $v     ; $var_G = $var_1  ; $var_B = $var_2 ;
			}

			$r = $var_R * 255;
			$g = $var_G * 255;
			$B = $var_B * 255;
		}
		return array($r, $g, $B);
	}
}

?>