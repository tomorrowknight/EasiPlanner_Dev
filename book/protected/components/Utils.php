<?php
class Utils {
	public static function loadJs($path) {
		$baseUrl =empty(Yii::app()->theme)?Yii::app ()->request->baseUrl:Yii::app()->theme->baseUrl;
		Yii::app ()->getClientScript ()->registerScriptFile ( "$baseUrl$path" );
	}
	public static function loadCss($path) {
		$baseUrl =empty(Yii::app()->theme)?Yii::app ()->request->baseUrl:Yii::app()->theme->baseUrl;
		Yii::app ()->getClientScript ()->registerCssFile ( "$baseUrl$path" );
	}
	public static function displayErr($model, $attribute) {
		if ($model->getError ( $attribute )) {
			echo "<span class='label important'>" . $model->getError ( $attribute ) . "</span>";
		}
	}
	public static function addToFavorite($user_id, $node_id) {
		$favorite = new Favorite ();
		$favorite->user_id = $user_id;
		$favorite->node_id = $node_id;
		$favorite->save ();
	}
	public static function loadByPk($class, $id, $withs = null) {
		$obj = new $class ();
		$obj = $obj->model ();
		if ($withs) {
			foreach ( $withs as $with ) {
				$obj = $obj->with ( $with );
			}
		}
		$obj = $obj->findByPk ( $id );
		if (empty ( $obj )) {
			throw new CHttpException ( "404", "Not found" );
		}
		return $obj;
	}
	public static function load($mixed, $type = 0) {
		// if array
		if (is_array ( $mixed )) {
			foreach ( $mixed as $type => $single_path ) {
				Utils::load ( $single_path, $type );
			}
			return;
		}
		// if single
		if (! is_numeric ( $type )) {
			if ($type == 'js') {
				Utils::loadJs ( $mixed );
			} else if ($type == 'css') {
				Utils::loadCss ( $mixed );
			}
		} else {
			if (preg_match ( "/\.js$/", $mixed )) {
				Utils::loadJs ( $mixed );
			} else {
				Utils::loadCss ( $mixed );
			}
		}
	}
	public static function cutString($string, $length) {
		if (mb_strlen ( $string ) <= $length) {
			return $string;
		} else {
			return mb_substr ( $string, 0, $length, 'utf8' ) . " ...";
		}
	}
	public static function loadAll($class, $condition = null, $params = null, $order = null, $limit = null, $withs = null) {
		$obj = new $class ();
		$criteria = new CDbCriteria ();
		$criteria->condition = $condition;
		$criteria->params = $params;
		$criteria->order = $order;
		if (! empty ( $limit )) {
			$criteria->limit = $limit;
		}
		$obj = $obj->model ();
		if ($withs) {
			foreach ( $withs as $with ) {
				$obj = $obj->with ( $with );
			}
		}
		return $obj->findAll ( $criteria );
	}
	// Template engine. Replace all the occurance of {var} by the values in the array $vars
	public static function template($template, $vars) {
		$return = $template;
		foreach ( $vars as $var ) {
			$return = preg_replace ( "/{var}/", $var, $return, 1 );
		}
		return $return;
	}
	
	// Get the absolute file path from a relative path.
	// Input: "/images/cover/1.png". Output: "D:/www/webapp/protected/../images/cover/1.png"
	public static function getFilePath($relativePath) {
		return Yii::app ()->basePath . "/../" . $relativePath;
	}
	
	// Get the weburl from a relative path
	// Input: "/images/cover/1.png". Output: "http//localhost/webapp/images/cover/1.png"
	public static function getFileUrl($relativePath) {
		return Yii::app ()->baseUrl . $relativePath;
	}
	public static function getThemeFileUrl($relativePath){
		$baseUrl =empty(Yii::app()->theme)?Yii::app ()->request->baseUrl:Yii::app()->theme->baseUrl;
		return $baseUrl . $relativePath;
	}
	
	public static function getImagePathTemplate() {
		return "/imgs/{var}/{var}{var}.jpg";
	}

	// Get the location of a image by folder,type and id. Example return value: D:/www/webapp/images/floder/type.id.png
	public static function getImagePathById($folder, $type, $id) {
		return Utils::getFilePath ( Utils::template ( self::getImagePathTemplate(), array (	$folder,$type,	$id	) ) );
	}

	// Get the web url of a image by folder, type and id. Example return value: /floder/type.id.png
	public static function getImageUrlById($folder, $type, $id) {
		if (file_exists ( Utils::getImagePathById ( $folder, $type, $id ) )) {
			$filepath_relative = Utils::template ( self::getImagePathTemplate(), array ($folder,$type,$id) );
			return Utils::getFileUrl ( $filepath_relative );
		} else {
			return Utils::getFileUrl("/imgs/default/$folder$type.jpg");
		}
	}
	
	// Display a button if necessary
	public static function displayBtn($btn) {
		if (! Yii::app ()->user->isGuest && (Yii::app ()->user->name == $_GET ['username'] || Utils::isAdmin ( Yii::app () )->user->id)) {
			echo $btn;
		}
	}
	
	// Check if a member is an admin
	public static function isAdmin($user_id = null) {
		if (empty ( $user_id )) {
			$user_id = Yii::app ()->user->id;
		}
		$user = User::model ()->findByPk ( $user_id );
		if (! empty ( $user ) && $user->type == User::TYPE_ADMIN) {
			return true;
		}
		return false;
	}
	public static function isValidAddress($latitude, $longitude, $strict = true) {
		if ($latitude < 1 || $latitude > 1.8 || $longitude < 102 || $longitude > 105) {
			return false;
		}
		if ($strict && $latitude == 1.352083 && $longitude == 103.81983600000001) {
			return false;
		}
		return true;
	}
	public static function isOwn($id) {
		if (Yii::app ()->user->isGuest) {
			return false;
		}
		if (Utils::isAdmin ()) {
			return true;
		}
		$user_id = Yii::app ()->user->id;
		$node = Node::model ()->find ( "user_id = :user_id and id=:id", array (
				"user_id" => $user_id,
				"id" => intval ( $id ) 
		) );
		return ! empty ( $node );
	}
	public static function access($obj) {
		if ($obj->user_id != Yii::app ()->user->id and ! Utils::isAdmin ()) {
			throw new CHttpExeption ( 403 );
		}
	}
	public static function isVerified($node) {
		return ! Utils::isAdmin ( $node->user_id );
	}
	public static function header_expire($interval) {
		header("Cache-Control: max-age=$interval");
		header("Pragma: public");
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $interval) . ' GMT');
	}

	public static function header_last_modified($last_modified_time) {
		header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last_modified_time) . " GMT");
	}
	
	public static function queryString($key, $default = "") {
		if (! empty ( $_POST [$key] )) {
			return $_POST [$key];
		} else if (! empty ( $_GET [$key] )) {
			return $_GET [$key];
		}
		return $default;
	}
	public static function select($obj1, $obj2) {
		return empty ( $obj1 ) ? $obj2 : $obj1;
	}
	public static function mailsend($to, $subject, $body = null) {
		if (empty ( $to ))
			return;
		if (empty ( $body )) {
			$body = $subject;
		}
		$message = new YiiMailMessage ();
		$message->view = 'general';
		$message->setSubject ( $subject );
		$message->setBody ( array (
				'body' => $body 
		), 'text/html' );
		$message->addTo ( $to );
		$message->from = Yii::app ()->params ['adminEmail'];
		Yii::app ()->mail->send ( $message );
	}
	public static function smssend($phone, $msg) {
		$phone = trim ( $phone );
		if (! preg_match ( "/^[89]\d{7}$/", $phone )) {
			return;
		}
		$url = "https://tapi.starhub.com/sessions?action=create&token=565255447a464652755144706f6c6952544c475247486f4c6c576b7177737173687942736c41776b69437246&phone=$phone&msg=" . urlencode ( $msg );
		file_get_contents ( $url );
	}
	public static function output($node, $level, $expandArr = array()) {
		if ($level <= 0 && ! in_array ( $node->id, $expandArr )) {
			return;
		}
		
		$html = "<ul class='book-node'>";
		foreach ( $node->sub_nodes as $sub_node ) {
			$html .= "<li>";
			$html .= CHtml::link ( $sub_node->title, $sub_node->getUrl(),array("class"=>!empty($_GET['id']) && $_GET['id']==$sub_node->id?"active":"") );
			$html .= self::output ( $sub_node, $level - 1, $expandArr );
			$html .= "</li>";
		}
		return $html .= "</ul>";
	}
}