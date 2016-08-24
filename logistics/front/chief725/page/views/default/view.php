<?
use yii\helpers\Markdown;
use yii\helpers\Html;
$this->title = $title;
?>

<h3><?php echo $title?></h3>
<div>
<?php 
$content = preg_replace_callback("/\[[(.*?)\]]/", function($m) use($title) {return CHtml::link($m[1],array("page/view","title"=>$m[1]));}, $content);
echo Markdown::process($content);
?>
</div>

<?php if($isAdmin){
echo Html::a("编辑",array("add","title"=>$title),array("class"=>'button'));
}?>