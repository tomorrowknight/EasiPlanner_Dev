<h2><?php echo $title?></h2>
<div>
<?php echo $content?>
</div>

<?php if(!Yii::app()->user->isGuest){
echo CHtml::link("编辑",array("page/add","title"=>$title),array("class"=>'button'));
}?>