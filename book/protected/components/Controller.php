<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	public $pageDescription;
	public $pageKeywords;
	public $ads_count;
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public function init()	{
		parent::init();
	}
	
	public function setTheme(){
		$theme = Config::get(Config::$theme);
		if (!empty($theme)){
			Yii::app()->theme = Config::get(Config::$theme);
		}
	}
	
	public function renderAds($ads,$options=array(),$return=false){
		if ($this->ads_count>=3){
			return;
		}
		$this->ads_count++;
		if (!Config::get(Config::$enable_ads)!="false"){
			return;
		}
		$options["class"]="ads";
		$ads_html = $this->renderPartial("/ads/$ads",null,true);
		$ads_html = CHtml::tag("div",$options,$ads_html);
		if ($return){
			return $ads_html;
		}else{
			echo $ads_html;
		}
	}
}