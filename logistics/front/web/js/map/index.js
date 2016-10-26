/**
* This is the Backbone.js based module
*@module Backbone
*/


Spinner.prototype.show = function() {
	this.spin(document.getElementById("map_canvas"));
};

function l(msg) {
	console.log(msg);
}

var spinner = new Spinner();
var map;
var shadowLays = [];
var routesLays = [];
var drawingManager;

/**
* This method initializes the map and sets the map
*@class initialize 
*@static
*/
function initialize() {
	var myOptions = {
			zoom : parseInt(12),
			center : new google.maps.LatLng(1.34, 103.82),
			zoomControl : true,
			mapTypeControl: true,
			mapTypeControlOptions: {
				position: google.maps.ControlPosition.LEFT_BOTTOM
			},
	};
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	drawingManager = new google.maps.drawing.DrawingManager({
		drawingControl : true,
		drawingControlOptions : {
			position : google.maps.ControlPosition.TOP_LEFT,
			drawingModes : [ google.maps.drawing.OverlayType.RECTANGLE,
			                 google.maps.drawing.OverlayType.MARKER ]


		},

	});

	drawingManager.setMap(map);
	google.maps.event
	.addListener(
			drawingManager,
			'overlaycomplete',
			function(event) {
				var overlay = event.overlay;
				if (event.type == google.maps.drawing.OverlayType.MARKER) {
					shadowLays.forEach(function(lay, i) {
						if (lay.getBounds().contains(
								overlay.getPosition())) {
							lay.setMap(null);
							parcels.triggerEach("onSelect", lay
									.getBounds(), false);
						}
					});
					overlay.setMap(null);
				} else {
					if ($("#time_horizon").val() == "") {
						alert("You need to select time horizon before doing assignment.");
						overlay.setMap(null);
						return;
					} else {
						onHorizonChanged();
						shadowLays.push(overlay);
						parcels.triggerEach("onSelect", overlay
								.getBounds(), true);
					}
				}
				onSelect();
			});

	google.maps.event.addListener(map, 'click', function(event) {
		setStatus(event.latLng.lat().toPrecision(6) + " : "
				+ event.latLng.lng().toPrecision(6));
	});


	var trafficLayer = new google.maps.TrafficLayer();
	trafficLayer.setMap(map);
}
/**
* This is executed when you select the parcels on the map
*@method onSelect
*@for index.js
*/
function onSelect() {
	$("#assignDiv").toggle(parcels.getSelectedParcels().length > 0);
	$("#autoFillBtn").toggle(
			parcels.getSelectedParcels().length <= 2
			&& $("#vehicle_id2").val() != "");
	setStatus(parcels.getSelectedParcels().length
			+ " parcels selected. Total volume: "
			+ parcels.getSelectedTotalVolume().toFixed(2));
}

/**
* This is executed when you select the parcels on the map
*@method setStatus
*@param status {String} the delivery status of the parcel
*/
function setStatus(status) {
	$("#statusLabel").text(status);
}

/**
* the method to execute the planned routes with spinner.js to show loading
*@method planRoutes
* 
*/
function planRoutes() {
	spinner.show();
	onHorizonChanged();

	vehicles.each(function(vehicle) {
		planRoute(vehicle);
	});
	spinner.stop();
}

/**
* the method to plan routes
*@method planRoute
@param vehicle {Vehicle} The vehicle used in planning the route
* 
*/
function planRoute(vehicle) {
	vehicle.capacity_weight = Number.MAX_VALUE;
	vehicle.capacity_volume = Number.MAX_VALUE;
	calRoute(profile, vehicle.parcels().getVisibleModels(), [ vehicle ], null,
			function(routes) {
		_.each(routes, function(route) {
			plotRoute(route);
			saveRoute(route);
		});
	});
}

/**
* the method to execute the clustered route result
@method planClusterRoutes
* 
*/
function planClustersRoutes() {
	log("plan all button clicked");
	spinner.show();
	onHorizonChanged();
	var emptyVehicles = vehicles.filter(function(vehicle) {
		return vehicle.parcels().length == 0;
	});
	log("plan vehicle start");
	calRoute(profile, parcels.getIdleParcels(), emptyVehicles, null, function(
			routes) {
		_.each(routes, function(route) {
			plotRoute(route);
			saveRoute(route);
		});
		spinner.stop();
	});
}

/**
* the method to calculate the routes based on the input args
@method calRoute
@param profile {Profile}  Argument 1 
@param planedParcels {Parcel}  Argument 2
@param vehicles {Vehicle} Argument 3
@param anchor {Vehicle} Argument 4
@param callback (Function)  Argument 5
@return {Function} the callback event of the calculated route
*/
function calRoute(profile, planedParcels, vehicles, anchor, callback) {
	if (planedParcels.length == 0)
		return;
	log("Loading distance matrix");
	matrix.load(profile, parcels, function() {
		var startTime = time();
		setStatus("StartTime: " + startTime);
		log("Begin routing");
		if(/near/.test(location.hash)){
			var routes =near(profile, planedParcels, vehicles, anchor);
		}else{
			var routes =tsptw(profile, planedParcels, vehicles, anchor);	
		}

		setStatus("Time taken: " + (time() - startTime) );
		log("Routing complete");
		callback(routes);
	});
}
/**
* the method to log the time
@method log
@param msg {String} Argument 1 
*/
function log(msg){
	console.log(new Date().toLocaleTimeString("en-US") +" : " + msg);
	setStatus(new Date().toLocaleTimeString("en-US") +" : " + msg);
}
/**
* the method to provide the time
@method time
*/
function time(){
	return Math.floor(new Date().getTime() / 1000);
}

/**
* the method to autofill the parcels with the vehicles
@method autoFill
*/
function autoFill() {
	var anchor = parcels.getSelectedParcels().at(0);
	calRoute(profile, parcels.getIdleParcels(), [ vehicles
	                                              .get($("#vehicle_id2").val()) ], anchor, function(route) {
		plotRoute(route);
		_.each(route.parcels, function(parcel) {
			parcel.set("selected", true);
		});
	});
}
/**
* the method to plot the routes
@method plotRoute
@param {Route} route Argument 1 
*/
function plotRoute(route) {
	var colors = [ "#00C81A", "#007CC6", "#00BE94", "#00A3C6", "#CB7100",
	               "#C000B2" ];
	var coordinates = _.map(route.parcels, function(parcel) {
		return parcel.marker.position;
	});

	var routePath = new google.maps.Polyline({
		path : coordinates,
		geodesic : true,
		strokeColor : route.vehicle.getColor(),
		strokeOpacity : 1.0,
		strokeWeight : 4
	});
	routesLays.push(routePath);
	routePath.setMap(map);
}

/**
* the method to save the routes
@method saveRoute
@param {Route} route Argument 1 
*/
function saveRoute(route) {
	_.each(route.parcels, function(parcel, index) {
		parcel.set("vehicle_id", route.vehicle.id);
		parcel.set("seq", index);
		parcel.set("route", route.id);
		parcel.save();
	});
}
/**
* the method to remove all the routes
@method clearAll
*/
function clearAll() {
	hide(routesLays);
	hide(shadowLays);
	parcels.each(function(parcel) {
		parcel.set("selected", false);
	});
}

/**
* the method to hide all the route layers
@method hide
*/
function hide(lays) {
	_(lays).each(function(overlay) {
		overlay.setMap(null);
	});
}
/**
* the method to flter all the parcels by vehicle or time windows
@method onFilterParcels
*/
function onFilterParcels() {
	clearAll();
	var vehicle_id = $("#vehicle_id").val();
	var window_start = $("#window_start").val();
	var window_end = $("#window_end").val();
	parcels.triggerEach("onFilter", vehicle_id, window_start, window_end);
}
/**
* the method to filter based on horizon change
@method onHorizonChanged
*/
function onHorizonChanged() {
	var horizonArr = ($("#time_horizon").val() || "0-24").split("-");
	var horizonStart = parseInt(horizonArr[0]);
	var horizonEnd = parseInt(horizonArr[1]);
	if ($("#window_start").val() != horizonStart
			|| $("#window_end").val() != horizonEnd) {
		$("#window_start").val(horizonStart);
		$("#window_end").val(horizonEnd);
		_.defer(onFilterParcels);
	}
	$(".time-window option").each(function() {
		if ($(this).val() >= horizonStart && $(this).val() <= horizonEnd) {
			$(this).removeAttr("disabled");
		} else {
			$(this).attr("disabled", "disabled");
		}
	});
}
/**
* the method to create the parcel markers
@method createParcelMarker
@param parcel {Parcel} Argument 1 
*/
function createParcelMarker(parcel) {
	var sameParcelsCount = parcels.where({
		lat : parcel.get("lat"),
		lng : parcel.get("lng")
	}).length - 1;
	var numParcelsPerCircle = 8;
	//var randomSN = Math.floor((Math.random() * 100) + 1);
	var radius = Math.ceil(sameParcelsCount / numParcelsPerCircle);
	var degree = 2 * Math.PI / numParcelsPerCircle
	* (sameParcelsCount % numParcelsPerCircle);
	parcel.set("lng", parcel.get("lng") + radius * 0.0001 * Math.sin(degree));
	parcel.set("lat", parcel.get("lat") + radius * 0.0001 * Math.cos(degree));
	parcel.set("identifier", parcel.get("identifier"));

	if(parcel.get("deliver_time")!=null){
		var parcelStatus = parcel.get("status");
		parcel.addDeliveryStatusMarker(new google.maps.LatLng(parcel.get("lat"),parcel.get("lng")),map,parcelStatus);
		google.maps.event.addListener(parcel.marker, 'click', function() {
			var infoWindow = new google.maps.InfoWindow({
				content : _.template($("#tmpl_parcel_window").html())(this.model)
			});
			infoWindow.open(map, this);
		});
	}else{
		parcel.createMarker(map);
		google.maps.event.addListener(parcel.marker, 'click', function() {
			var infoWindow = new google.maps.InfoWindow({
				content : _.template($("#tmpl_parcel_window").html())(this.model)
			});
			infoWindow.open(map, this);
		});
		
	}

}
/**
* the method to geocode the parcels
@method geocodeParcel
@return {Parcel} returns the geocoded parcel
*/
function geocodeParcel() {
	for (var i = 0; i < parcels_blank.length; i++) {
		parcel = parcels_blank.at(i);
		if (!empty(parcel.get("lat")) || parcel.get("failed") == 1)
			continue;
		console.log("Geocoding " + parcel.get("postal"));
		geocode("Singapore", parcel.get("postal"), function(results, status) {
			if (results != null && results.length > 0) {
				console.log("Geocoded successfully " + parcel.get("postal"));
				var latLng = results[0].geometry.location;
				console.log("updating");
				parcel.set("lat", latLng.lat());
				parcel.set("lng", latLng.lng());
				parcel.set("failed", 0);
				parcel.save();
				parcels.add(parcel);
				createParcelMarker(parcel);

				$.get(site.urlTo("geocode/update-geocode"), {
					postal : parcel.get("postal"),
					lat : latLng.lat(),
					lng : latLng.lng()
				});
				setTimeout(function() {
					geocodeParcel();
				}, Math.random() *1000);
			} else {
				(function(parcel) {
					console.log("Guess Geocoding " + parcel.get("postal"));
					$.getJSON(site.urlTo("geocode/guess-geocode"), {
						postal : parcel.get("postal")
					}).done(function(latLng) {
						if (!empty(latLng.lat)) {
							parcel.set("lat", latLng.lat);
							parcel.set("lng", latLng.lng);
							parcels.add(parcel);
							createParcelMarker(parcel);
						}
						parcel.set("failed", 1);
						parcel.save();
						setTimeout(function() {
							geocodeParcel();
						}, Math.random() * 1000);
					});
				})(parcel);
			}
		});
		return;
	}
}

var parcels = new Parcels;
var parcels_blank = new Parcels;
var vehicles = new Vehicles;
var profile = new Profile;
var drivers = new Drivers;

/**
* the method create the initial map overlay of parcels updates the selection of parcels
@method callback
@return {Boolean} returns true on the success of an updated parcel
*/
$(function() {
	// execute
	initialize();
	spinner.show();

	drivers.fetch({
		success : function() {
			vehicles.fetch({
				success : function(models, response, options) {
					models.each(function(vehicle) {
						if (!empty(vehicle.driver()))
							vehicle.createMarker(map);
					});
				}
			});
		}
	});

	parcels.fetch({
		success : function(ps, response, options) {
			spinner.stop();
			ps.each(function(parcel) {
				if (empty(parcel)) {
					parcels.remove(parcel);
					console.log("empty?");
				} else if (!empty(parcel.get("lat"))) {
					createParcelMarker(parcel);
				} else {
					parcels_blank.add(parcel);
				}
			});
			parcels.remove(parcels_blank.toArray());
			geocodeParcel();
		}
	});

	profile.fetch({
		success : function(model, response, options) {
			model.createMarker(map);
		}
	});

	$('#datetimepicker').datetimepicker({
		pickTime : false
	});

	$("#datetimepicker").change(function() {
		$("#datetimepickerForm").submit();
	});

	$("#vehicle_id2").change(
			function() {
				$("#autoFillBtn").toggle(
						parcels.getSelectedParcels().length <= 2
						&& $("#vehicle_id2").val() != "");
			});

	$("#autoFillBtn").click(function(e) {

	});

	$("#assignBtn")
	.click(
			function(e) {
				e.preventDefault();

				// find vehicle
				var vehicleId = $("#vehicle_id2").val();
				var vehicle = vehicles.get(vehicleId);
				if (vehicle == null)
					vehicle = {
						id : 0
				};

				// check capacity

				if (vehicleId != "") {
					var leftVolume = vehicle.getCapacityVolumeLeft()
					- parcels.getSelectedTotalVolume();
					var leftWeight = vehicle.getCapacityWeightLeft()
					- parcels.getSelectedTotalWeight();
					if ((leftVolume < 0 || leftWeight < 0)
							&& false == confirm("Vehicle overloaded. Volume left  "
									+ leftVolume.toFixed(2)
									+ ". Weight left "
									+ leftWeight.toFixed(2)
									+ ". Confirm to assign?")) {
						return false;
					}
				}

				hide(shadowLays);
				spinner.show();
				var selectedParcels = parcels.getSelectedParcels();
				selectedParcels
				.each(function(parcel) {
					parcel.set("selected", false);
					if (parcel.get("vehicle_id") != vehicle.id) {
						parcel
						.save(
								{
									vehicle_id : vehicle.id,
									seq : 0
								},
								{
									patch : true,
									success : function() {
										setStatus("Updated parcel "
												+ (selectedParcels
														.indexOf(parcel) + 1)
														+ "/"
														+ selectedParcels.length);
										parcel
										.set(
												"vehicle_id",
												vehicle.id);
										if (selectedParcels.length
												- selectedParcels
												.indexOf(parcel) < 6) {
											spinner
											.stop();
										}
									}
								});
					}
				});
				onSelect();
				return false;
			});
});
