<?php
use yii\widgets\DetailView;
use app\models\VehicleType;
use chief725\libs\Utils;
use yii\helpers\Html;
use chief725\libs\__;
use app\models\Parcel;
use yii\bootstrap\Nav;
use yii\bootstrap\ActiveForm;
use app\assets\TrackAsset;
use yii\grid\GridView

?>
<?

TrackAsset::register ( $this );

$this->params ['breadcrumbs'] [] = "Parcel #$model->id";

$items = [ ];
foreach ( Parcel::getStatusLabels () as $index => $status ) {
	if ($index == Parcel::STATUS_PENGING)
	continue;
	$items [] = [
	'label' => $status ['text'],
	'url' => [
	"update-status",
	"id" => $model->id,
	'status' => $index
	],
	'active' => $index == $model->status,
	'linkOptions' => [
	'style' => 'border:1px solid #ddd',
	'onclick' => "return confirm('Confirm?')"
	]
	];
}
if ($model->status != Parcel::STATUS_DONE)
echo Nav::widget ( [
'options' => [
'class' => 'nav nav-pills margin-bottom-10'
],
'items' => $items,
'encodeLabels' => false,
'activateParents' => true
] );

echo DetailView::widget ( [
'model' => $model,
'attributes' => [
'identifier',
'address',
[
'label' => 'Postal',
'format' => 'raw',
'value' => Html::a ( Utils::icon ( "map-marker" ) . $model->postal, [
'map',
'id' => $model->id
], [
'class' => "btn btn-success"
] )
],
'customer_name',
[
'label' => 'Phone',
'format' => 'raw',
'value' => Html::a ( Utils::icon ( "phone-alt" ) . $model->phone, "tel:$model->phone", [
'class' => "btn btn-success"
] )
]
]
] );
?>

<div class="modal fade" tabindex="-1" role="dialog" id='signature'>
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"
aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
<h4 class="modal-title">Signature</h4>
</div>
<div class="modal-body">
<canvas style='width: 100%; height: 200px' id='canvas'></canvas>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
<button type="button" class="btn btn-primary"
onclick='uploadSignature()'>Done</button>
</div>	
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<hr>
<button type='button' onclick='openSignature()'
class='btn btn-lg btn-success'><?=Utils::iconfa("pencil-square-o") ?>Signature</button>
<br />
<img id='signatureImage' class='img img-responsive'
src='<?=$model->signature ?>'>
<hr>
<?php $form = ActiveForm::begin(['enableClientScript'=>false,'options' => ['enctype' => 'multipart/form-data','id'=>'form']]); ?>
<script>
function onFileUpload(){
	$("#form").submit();
	$("#uploading").show();
	$("#uploadDiv").hide();
}
</script>
<div class='alert alert-danger' style='display: none;' id='uploading'>UPLOADING...</div>
<div class='margin-top-10 margin-bottom-10' id='uploadDiv'>
<button type='button' class='btn btn-success btn-lg'
onclick='$("#file").click();'><?=Utils::icon("camera") ?>Take Picture</button>
<input id='file' type="file" style='display: none'
name="parcelImages[]" onchange='loadFile(event)' multiple="multiple"
accept="image/*" capture>
<button type='button' class='btn btn-success btn-lg'
onclick='onFileUpload()'><?=Utils::icon("send") ?>Upload Picture</button>
</div>
<div class='margin-top-10 margin-bottom-10' id='uploadDiv'>


<?ActiveForm::end(); ?>

<img id = 'output' class='img img-responsive margin-bottom-10'>

<?

foreach ( $model->images as $image ) {
	echo $image->getImageHtml ( [
			'class' => "img img-responsive margin-bottom-10"
			
	] );
}
?>


<div>
<button type="button" class="btn btn-danger" id="clear_btn"
onclick='removeImage()'><?=Utils::icon("trash") ?>Delete Image</button></button>
</div>


<script>
function uploadSignature(){
	$.post(window.location.href,{'signature':signaturePad.toDataURL(),'id':<?=$model->id?>},function(data){
		if(data.status == "yes"){
			$("#signatureImage").attr("src",signaturePad.toDataURL());
			$("#signature").modal('hide');
		}else{
			alert("Error uploading the signature.Please check your connection");
		}
	});
}

  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
  
  function removeImage(){
	  var output = document.getElementById('output');
	  var value = output.src;
	  output.src = URL.revokeObjectURL(output.src);
	  location.reload();
	  
	  
  }

</script>

