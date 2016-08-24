<?php
class NodeController extends Controller {
	public function filters() {
		$filters = array ();
		$filters [] = 'accessControl';
		$filters [] = array (
				'COutputCache + index',
				'duration' => 0,
				'varyByParam' => array (
						'id'
				)
		);
		return $filters;
	}
	public function accessRules() {
		return array (
				array (
						'allow',
						'actions' => array (
								'index'
						),
						'users' => array (
								'*'
						)
				),
				array (
						'allow',
						'actions' => array (
								'add',
								'admin',
								'delete'
						),
						'users' => array (
								'@'
						)
				),
				array (
						'deny',
						'users' => array (
								'*'
						)
				)
		);
	}
	public function actionAdd($id,$edit=false) {
		$maxNode = Node::model()->find(array("condition"=>"parent_id=$id","limit"=>1,"order"=>"seq desc"));
		$node = Node::createNode ( $id, "", empty($maxNode)?1: $maxNode->seq+1, "" );
		$this->redirect ( array (
				"node/admin",
				"id" => empty($edit)?$id: $node->id
		) );
	}
	public function actionDelete($id) {
		$node = Utils::loadByPk ( "Node", $id );
		$parent_id = $node->parent_id;
		$node->remove ();
		$this->redirect ( array (
				"node/admin",
				"id" => $parent_id
		) );
	}
	public function actionAdmin($id = null) {
		$this->layout = '//layouts/admin';
		if (isset ( $_POST ["SubNodes"] )) {
			foreach ( $_POST ["SubNodes"] as $SubNodeArr ) {
				$sub_node = Node::model ()->findByPk ( $SubNodeArr ['id'] );
				$sub_node->attributes = $SubNodeArr;
				if (! $sub_node->save ()) {
					print_r ( $sub_node->getErrors () );
					exit ();
				}
			}
		}
		if (isset ( $_POST ["Node"] )) {
			$node = Node::model ()->findByPk ( $_POST['Node']['id'] );
			$node->attributes = $_POST['Node'];
			$node->save();
			if (isset($_POST["save"])){
				$this->redirect(array("node/admin","id"=>$node->parent_id));
			}

			// upload images
			if(isset($_FILES['nodeImage'])){
				foreach ($_FILES['nodeImage']['name'] as $imageIndex => $imageName) {
					$image_file=CUploadedFile::getInstanceByName("nodeImage[$imageIndex]");
					if(empty($image_file)){
						continue;
					}
					$image = new Image();
					$image->node_id = $node->id;

					if(!$image->save()){
						print_r($image->getErrors());
						exit;
					}
					$file = $image->getPath();


					$image_file->saveAs($file);
					if(!ImageUtils::resize($file, $file, 800, 800, false)){
						$image->delete();
						continue;
					}
				}
			}
			//delete images
			if(isset($_POST['deleteImage'])){
				foreach ($_POST['deleteImage'] as $imageId){
					$image = Image::model()->findByPk($imageId);
					$image->delete();
					@unlink($image->getPath());
				}
			}
		}

		$node = isset($id)? Utils::loadByPk ( "Node", $id ):Node::getRootNode() ;
		$expandNodeArr = array();
		$parent = $node->parent;
		while (!empty($parent)){
			array_unshift($expandNodeArr, $parent);
			$parent = $parent->parent;
		}
		$this->render ( 'admin', array (
				"node" =>$node,
				'expandNodeArr'=>$expandNodeArr
		) );
	}

	public function actionIndex($id = null) {
		$cache_duration = Config::get(Config::$cache_duration);
		if (!empty($cache_duration)){
			Utils::header_expire($cache_duration);
		}

		$this->setTheme();

		$node = isset($id)? Utils::loadByPk ( "Node", $id ):Node::getRootNode() ;
		if (!empty($node->content)){
			$node->updateCounter();
		}
		$this->pageTitle =$node->title;
		$expandArr = array($node->id);
		$expandNodeArr = array();
		$parent = $node->parent;
		while (!empty($parent)){
			$expandArr[] = $parent->id;
			array_unshift($expandNodeArr, $parent);
			$this->pageTitle .= " - $parent->title";
			$parent = $parent->parent;
		}

		if($id == 1){
			$this->pageDescription = Config::get(Config::$description);
			$this->pageKeywords = Config::get(Config::$keywords);
		}else{
			$this->pageKeywords = str_replace("-", ",", $this->pageTitle);
		}

		if (Config::isEnable("prefetch")){
			foreach ($node->sub_nodes as $sub_node){
				$url = $this->createUrl('node/index',array("id"=>$sub_node->id));
				Yii::app()->clientScript->registerLinkTag('prefetch',null,$url);
				Yii::app()->clientScript->registerLinkTag('prerender',null,$url);
			}
		}


		$this->render ( 'index', array (
				"id"=>$id,
				"node" => $node,
				"expandArr"=>$expandArr,
				"expandNodeArr"=>$expandNodeArr,
		) );
	}
	public function actionSubmit() {
		$this->render ( 'submit' );
	}
}