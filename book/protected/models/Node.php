<?php

/**
 * This is the model class for table "node".
 *
 * The followings are the available columns in table 'node':
 * @property string $id
 * @property string $parent_id
 * @property string $seq
 * @property string $title
 * @property string $url
 * @property integer $hits
 * @property string $color
 */
class Node extends CActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 *
	 * @param string $className
	 *        	active record class name.
	 * @return Node the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}

	public function beforeSave() {
		if (Config::isEnable("highlight")){
			$this->content = $this->removeBrInPre($this->content);
			$this->content = preg_replace("#<pre[^>]*>#", "<pre class='brush: js'>", $this->content);
		}
		return parent::beforeSave();
	}

	private function removeBrInPre($str){
		if (empty($str)){
			return $str;
		}
		
		$dom = new DOMDocument();
		$dom->loadHTML($str);
		$preElements = $dom->getElementsByTagName('pre');
		if ( count( $preElements ) ) {
			foreach ( $preElements as $pre ) {
				$newInnerHTML  = preg_replace( "#<br[^>]*>#i", "\n", $dom->saveXML($pre)  );
				$newInnerHTML  = preg_replace( "#<[^>]*?pre[^>]*?>#", "\n", $newInnerHTML );
				$newElement = $dom->createElement($pre->nodeName, $newInnerHTML);
				$pre->parentNode->insertBefore($newElement,$pre);
				$pre->parentNode->removeChild($pre);
			}
			return $dom->saveHTML();
		}else{
			return $str;
		}
	}

	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'node';
	}
	public function updateCounter(){
		$this->saveCounters(array('hits'=>1));
		if (!empty($this->parent)){
			$this->parent->updateCounter();
		}
	}
	/**
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array (
				array (
						'',
						'required'
				),
				array (
						'hits',
						'numerical',
						'integerOnly' => true
				),
				array (
						'parent_id, seq',
						'length',
						'max' => 10
				),
				array (
						'title',
						'length',
						'max' => 255
				),
				array (
						'seq, title,content,url, hits,parent_id',
						'safe'
				)
		);
	}

	/**
	 *
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array (
				'sub_nodes' => array (
						self::HAS_MANY,
						'Node',
						'parent_id',
						"order" => "seq asc, hits desc"
				) ,
				'parent' => array(self::BELONGS_TO, 'Node','parent_id'),
				'images' => array(self::HAS_MANY, 'Image', 'node_id'),
		);
	}

	/**
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array (
				'id' => 'ID',
				'parent_id' => 'Parent',
				'seq' => 'Seq',
				'title' => 'Title',
				'content' => 'Content',
				'hits' => 'Hits'
		);
	}
	public function remove() {
		foreach ( $this->sub_nodes as $subNode ) {
			$subNode->remove ();
		}

		foreach ($this->images as $image){
			$image->remove();
		}

		$this->delete ();
	}
	public static function createNode($parent_id, $title, $seq = 99, $content = "") {
		$node = new Node ();
		$node->domain = DOMAIN;
		$node->parent_id = $parent_id;
		$node->seq = $seq;
		$node->content = $content;
		$node->title = $title;
		$node->save ();
		return $node;
	}

	public static function getRootNode(){
		$node = Node::model()->find(array("order"=>"id asc",'condition'=>"domain='".DOMAIN."'"));
		if (empty ( $node )) {
			$node = new Node ();
			$node->domain = DOMAIN;
			$node->parent_id = 0;
			$node->title = "This is Root Node";
			$node->save ();
		}
		return $node;
	}

	public function getUrl(){
		if (!empty($this->url)){
			return $this->url;
		}else{
			return Yii::app()->createAbsoluteUrl("node/index",array("id"=>$this->id));
		}
	}
}