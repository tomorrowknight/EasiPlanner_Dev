<?php
use chief725\libs\Utils;

use yii\bootstrap\ActiveForm;

use app\models\Parcel;

use yii\helpers\ArrayHelper;

use app\assets\MapAsset;

use yii\helpers\Url;

use yii\helpers\Html;
use yii\widgets\Menu;
$this->title = 'Logistics route planning';

MapAsset::register ( $this );
?>

<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<?=Html::a( Utils::iconfa("bars"),"#",['class'=>"navbar-brand",'onclick'=>'$("#left_panel").toggleClass("hide1")'])?>
			<?=Html::a( " Logistics",["/"],['class'=>"navbar-brand"])?>
		</div>

		<div class="btn-group">
			<button type="button" class="btn btn-primary navbar-btn"
				data-toggle="tooltip" data-placement="bottom"
				title="Refresh the page" onclick='location.reload();'>
				<span class="glyphicon glyphicon-refresh"></span>
			</button>
		</div>
		<div class="btn-group">
			<button type="button" class="btn btn-danger navbar-btn"
				data-toggle="tooltip" data-placement="bottom" title="Plan routes"
				onclick='planRoutes()'>
				<span class="glyphicon glyphicon-play"></span>
			</button>
			<button type="button" class="btn btn-warning navbar-btn"
				data-toggle="tooltip" data-placement="bottom"
				title="Cluster and plan routes" onclick='planClustersRoutes()'>
				<span class="glyphicon glyphicon-forward"></span>
			</button>
			<button type="button" class="btn btn-info navbar-btn"
				data-toggle="tooltip" data-placement="bottom"
				title="Remove route overlay" onclick='clearAll()'>
				<span class="glyphicon glyphicon-remove"></span>
			</button>
			<button type="button" class="btn btn-success navbar-btn"
				data-toggle="tooltip" data-placement="bottom"
				title="Refresh Delivered Jobs" onclick='completedDelivery()'>
				<span class="glyphicon glyphicon-pushpin"></span>
			</button>
		</div>
		<?
		echo $this->render ( "/layouts/_nav" );
		?>
	</div>
</nav>


<div id="map_canvas" style="height: 100%; width: 100%"></div>
<style>
#left_panel {
	position: fixed;
	top: 50px;
	left: 0px;
	width: 300px;
	height: 10000px;
	background: #F8F8F8;
	transition: all 0.5s;
	padding: 10px;
}

#left_panel {
	
}

#left_panel.hide1 {
	left: -300px;
	transition: all 0.5s;
}

#left_panel #toggle {
	position: absolute;
	top: 0;
	right: 0px;
	display: block;
	width: 40px;
	height: 40px;
}
</style>
<script>
window.onload = function(){$('#jstree_demo_div').jstree();};
</script>
<div id='left_panel' class='hide1'>
	<button type='button' id='toggle'
		onclick='$("#left_panel").toggleClass("hide1")'><?=Utils::icon("backward")?></button>
	<h2><?=count(Yii::$app->user->identity->activeVehicles) ?> Vehicles</h2>
	<div id='jstree_demo_div'>
		<?
		$items = [ ];
		foreach ( Yii::$app->user->identity->activeVehicles as $vehicle ) {
			$sub_items = [ ];
			foreach ( $vehicle->parcels as $index => $parcel ) {
				$time = date ( "H:i", $parcel->planned_deliver_time * 60 );
				$sub_items [] = [ 
						'label' => ($index + 1) . ": $parcel->identifier ($time)",
						'options' => [ 
								"data-jstree" => '{"icon":"glyphicon glyphicon-gift"}' 
						],
						"encodeLabels" => false 
				];
			}
			$num_parcels = count ( $vehicle->parcels );
			$items [] = [ 
					'label' => "$vehicle->name ($num_parcels parcels)",
					'items' => $sub_items,
					"encodeLabels" => false,
					'options' => [ 
							"data-jstree" => '{"icon":"fa fa-car"}' 
					] 
			];
		}
		echo Menu::widget ( [ 
				'items' => $items 
		] );
		?>
	</div>
</div>

<div id='map_controls' class='toolbox'>
	<div>
		<h4>Time window</h4>
		<div class='form-group'>

			<div class='row'>
				<div class='col-lg-12 form-group'>
					<form method='get' id='datetimepickerForm'>
						<div class='input-group date' id='datetimepicker'>
							<input class="form-control"
								value='<?=Utils::queryString("date",date("Y-m-d")) ?>'
								data-date-format="YYYY-MM-DD" name="date" type="text" /> <span
								class="input-group-addon"><i
								class="glyphicon glyphicon-calendar"></i> </span>

						</div>
					</form>
				</div>

				<?
				$horizons = Yii::$app->user->identity->horizons;
				
				$horizonsArr = [ ];
				if (empty ( $horizons )) {
					$horizonsArr ["0-24"] = "0-24";
				} else {
					foreach ( $horizons as $horizon ) {
						$horizonsArr ["$horizon->start-$horizon->end"] = "$horizon->start - $horizon->end";
					}
				}
				?>
				<div class='col-lg-12'>
					<div class="form-group">
						<label>Time Horizon</label>
						<?
						if (empty ( $horizons )) {
							echo Html::dropDownList ( "time_horizon", 0, $horizonsArr, [ 
									'class' => "form-control",
									"id" => "time_horizon",
									"onchange" => "onHorizonChanged()" 
							] );
						} else {
							echo Html::dropDownList ( "time_horizon", 0, $horizonsArr, [ 
									'class' => "form-control",
									"id" => "time_horizon",
									'prompt' => "Seletct Time Horizon",
									"onchange" => "onHorizonChanged()" 
							] );
						}
						?>
					</div>
				</div>

				<div class='col-xs-6'>
					<div class="form-group" style='margin-bottom: 0'>
						<label>From</label>
						<?=Html::dropDownList("window_start",0,range(0, 23),['class'=>"form-control time-window","id"=>"window_start","onchange"=>"onFilterParcels()"]); ?>
					</div>
				</div>
				<div class='col-xs-6'>
					<div class="form-group" style='margin-bottom: 0'>
						<label>To</label>
						<?=Html::dropDownList("window_end",24,range(0, 24),['class'=>"form-control time-window","id"=>"window_end","onchange"=>"onFilterParcels()"]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div id='vehiclesDiv'>
		<h4>Filter by vehicle</h4>
		<div class='form-group'>
			<?
			$vehicles = [ ];
			foreach ( Yii::$app->user->identity->activeVehicles as $vehicle ) {
				$vehicles [$vehicle->id] = "$vehicle->name ($vehicle->capacity_volume | $vehicle->capacity_weight)";
				if (! empty ( $vehicle->driver )) {
					$vehicles [$vehicle->id] .= "[" . $vehicle->driver->username . "]";
				}
			}
			$vehicles ["0"] = "Others";
			echo Html::dropDownList ( 'vehicle_id', null, $vehicles, [ 
					"id" => "vehicle_id",
					'class' => "form-control",
					'prompt' => 'All vehicles',
					'empty' => 'All',
					"onchange" => "onFilterParcels()" 
			] )?>
		</div>
	</div>
	<hr>
	<div id='assignDiv'>
		<h4>Assign parcels</h4>
		<? $form = ActiveForm::begin(['action'=>Url::to(["map/assign-parcels"]),'options'=>["id"=>"assignForm"]]); ?>
		<? $model = new Parcel();?>
		<div class='form-group'>
			<?= Html::dropDownList('vehicle_id',null,ArrayHelper::map(Yii::$app->user->identity->activeVehicles, 'id', 'name'),['class'=>"form-control",'prompt'=>"None","id"=>"vehicle_id2"])?>
		</div>
		<?= Html::hiddenInput('parcel_ids',null,['id'=>'parcel_ids'])?>

		<div class="form-group">
			<?= Html::submitButton("Assign", ['class' => 'btn btn-success',"id"=>"assignBtn"])?>
			<button type='button' onclick='autoFill()' class='btn btn-info'
				id='autoFillBtn'>Auto Fill</button>
		</div>
		<?ActiveForm::end()?>
	</div>
</div>


<div id='statusDiv' class='toolbox'>
	<i class='glyphicon glyphicon-info-sign'></i> <label id='statusLabel'>Here
		is the status message.</label>
</div>

<script type="text/html" id="tmpl_parcel_window">
<table class='table table-bordered table-striped'>

<tr><td>ID</td><td><%=id%></td></tr>
<tr><td>Phone</td><td><%=obj.get('phone')%></td></tr>
<tr><td>Address</td><td><%=obj.get('address')%></td></tr>
<tr><td>Postal</td><td><%=obj.get('postal')%></td></tr>
<tr><td>vehicle</td><td><%print(obj.vehicle().id==0 ? "Not Assigned!" : obj.vehicle().get("name") )%></td></tr>
<tr><td>identifier</td><td><%=obj.get("identifier")%></td></tr>
<tr><td>customer_name</td><td><%=obj.get("customer_name")%></td></tr>
<tr><td>Note</td><td><%=obj.get("note")%></td></tr>
<tr><td>volume</td><td><%=obj.get("volume")%></td></tr>
<tr><td>Weight</td><td><%=obj.get("weight")%></td></tr>
<tr><td>Time Window Start</td><td><%=obj.get("window_start")%></td></tr>
<tr><td>Time Window End</td><td><%=obj.get("window_end")%></td></tr>
<tr><td>ServiceTime</td><td><%=obj.get("service_time")%></td></tr>
<tr><td>DeliverTime</td><td><%=new Date((parseInt(obj.get("planned_deliver_time")) + new Date().getTimezoneOffset() )*60000)%></td></tr>
</table>
</script>

<script type="text/html" id="tmpl_vehicle_window">
<table class='table table-bordered table-striped'>

<tr><td>ID</td><td><%=id%></td></tr>
<tr><td>Driver</td><td><%print(driver==null ? "Not Assigned!" : driver.username )%></td></tr>
<tr><td>Capacity</td><td><%=capacity%></td></tr>

</table>
</script>

<script>
var speedFactor = <?=Yii::$app->user->identity->profile->speed_factor?>;
</script>
