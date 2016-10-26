/**
* This the Backbone.js based module
*@module Backbone
*/

/**
* This the Super class for the Model required for establishing parcels on a map
*@class Supermodel
*@static
*/

var SuperModel = {
/**
* This model for setting the parcels on the map
*@method urlRoot
*@return url {String} returns the url of the model
*/
	Model : Supermodel.Model.extend({
		name : "",
		urlRoot : function() {
			return site.urlTo(this.name + 's');
		},
/**
* This function initializes the parcels on the map
*@method initialize
*
*/
		initialize : function() {
			Supermodel.Model.prototype.initialize.apply(this, arguments);
			this.boot();
		},
/**
* This function creates the markers on the map
*@method createMarker
*
*/
		createMarker : function(map) {
			this.map = map;
			this.marker = new google.maps.Marker({
				position : this.getPosition(),
				map : map,
				model : this
			});
			this.marker.setIcon(this.getIcon());
		},
/**
* This function gets the icons for the map
*@method getIcon
*@return url {String} the icon url
*/
		getIcon : function() {
			return this.getIconUrl(this.id);
		},
/**
* This function gets the url for the icons for the map
*@method getIconUrl
*@return url {String} returns the icon url
*/
		getIconUrl : function(index) {
			return site.urlTo("image/view?name=" + this.name + "&id=" + index);
		},
/**
* This function gets the coordinates to place the marker on the map
*@method Position
*@return latlng {LatLng} this returns a geocoded marker
*/
		getPosition : function() {
			return new google.maps.LatLng(this.get('lat'), this.get('lng'));
		},
/**
* This function gets the distance from one marker to another marker
*@method distance
*@param model {SuperModel.model} the model used to set the distance
*@return distanceBetween (double) returns the distance between two markers
*/
		distance : function(model) {
			return google.maps.geometry.spherical.computeDistanceBetween(this
					.getPosition(), model.getPosition());
		},
/**
* This function gets the travel time of the model
*@method travelTime
*@param model {SuperModel.model} the model used to set the time
*/
		travelTime : function(model) {
			return this.distance(model) / 500;
		},
		boot : function() {
		},
		setMarkerIcon : function() {
		},
	}),
/**
* This is a backbone class for extending the search
*@class Collection
*@constructor 
*/
	Collection : Backbone.Collection.extend({
		triggerEach : function() {
			var args = Array.prototype.slice.call(arguments);
			func = args.shift();
			this.each(function(model) {
				model[func].apply(model, args);
			});
		},
/**
* This function gets the search for the model
*@method triggerEach
*@param model {SuperModel.model} the model used to set the time
*/
		search : function(func) {
			return new this.constructor(this.filter(func));
		},
/**
* This function gets the search for the model which are not empty
*@method triggerEach
*@param model {SuperModel.model} the model used to set the time
*@return parcel.marker {Parcel} returns the non empty parcel marker
*/
		getVisibleModels : function() {
			return this.search(function(parcel) {
				return !empty(parcel.marker) && !empty(parcel.marker.map);
			});
		}
	})
};

// Parcel
/**
* This the Super class for the Model required for establishing parcels on a map
*@class Supermodel
*@static
*/
var Parcel = SuperModel.Model
		.extend({
			name : "parcel",
			boot : function() {
				this.on('change:selected change:vehicle_id change:seq',
						function() {
							this.marker.setIcon(this.getIcon());
							if (empty(this.get("vehicle_id"))) {
								this.set("seq", "");
							}
						}, this);
			},
/**
* This function gets the colour of the vehicle marker based on the hex
*@method getColor
*@return color {hexColor} this returns a colour
*/
			getColor : function() {
				return hexColor(this.get("vehicle_id"));
			},
/**
* This function gets the inverted colour of the vehicle marker based on the hex
*@method getInvertColor
*@return color {hexInvertColor} this returns an Inverted colour
*/
			getInvertColor : function() {
				return hexInvertColor(this.get("vehicle_id"));
			},
/**
* This function gets marker icon url based on the hex
*@method getIcon
*@return iconUrl {String} this returns the marker icon url
*/
			getIcon : function() {
				if (this.get("selected")) {
					var fillColor = "ffffff";
					var textColor = "000000";
				} else if (empty(this.get("vehicle_id"))) {
					var fillColor = "000000";
					var textColor = "ffffff";
				} else {
					var fillColor = this.getColor().slice(-6);
					var textColor = this.getInvertColor().slice(-6);
				}
				if (this.get("vehicle_id") == "" || this.get("vehicle_id") == null) {
					text = "";
				} else {
					text = (this.get("seq") + 1);
				}
				return "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld="
						+ text + "|" + fillColor + "|" + textColor;
			},
/**
* This function gets the window start date 
*@method getWindowStart
*@return startDate {Date} this returns the window start date (not time)
*/
			getWindowStart : function() {
				return createDate(this.get("window_start")).getHours()
						+ new Date().getTimezoneOffset() / 60;
			},
/**
* This function gets the window end date 
*@method getWindowEnd
*@return endDate {Date} this returns the window end date (not time)
*/
			getWindowEnd : function() {
				return createDate(this.get("window_end")).getHours()
						+ new Date().getTimezoneOffset() / 60;
			},
/**
* This function gets the window end time 
*@method getWindowStart
*@return startTime {Time} this returns the window start time
*/
			getWindowStartTime : function() {
				return parseDate(this.get("window_start")) / 60000;
			},
/**
* This function gets the window end time 
*@method getWindowEnd
*@return endTime {Time} this returns the window end time
*/
			getWindowEndTime : function() {
				return parseDate(this.get("window_end")) / 60000;
			},
/**
* This function gets the latest possible start time for the delivery
*@method getLatestStartTime
*@return latestStartTime {Time} this returns the latest possible start time for the delivery
*/
			getLatestStartTime : function() {
				return this.getWindowEndTime() - this.get("service_time");
			},
/**
* This function gets the latest possible end time for the delivery
*@method getLatestEndTime
*@return latestEndTime {Time} this returns the latest possible end time for the delivery
*/
			getServiceEndTime : function() {
				return this.get("planned_deliver_time")
						+ this.get("service_time");
			},
/**
* This function filters based on the start and end datetime
*@method onFilter
*
*/
			onFilter : function(vehicle_id, window_start, window_end) {
				var isWithIn = (this.getWindowStart() >= window_start && this
						.getWindowStart() <= window_end)
						|| (this.getWindowEnd() >= window_start && this
								.getWindowEnd() <= window_end);
				if ((vehicle_id == "" || this.get("vehicle_id") == vehicle_id || this
						.get("vehicle_id") == "")
						&& isWithIn) {
					this.marker.setMap(this.map);
				} else {
					this.marker.setMap(null);
				}
			},
/**
* This function sets the area bounds and the markers within
*@method onFilter
*
*/
			onSelect : function(bounds, selected) {
				if (!empty(this.marker)
						&& bounds.contains(this.marker.getPosition())) {
					this.set('selected', selected);
				}
			},
/**
* This function sets the area bounds and the markers within
*@method fitTo
*@param vehicle {Vehicle} uses the vehicle class to get types
*@return true {boolean} returns true if the vehicle type exists
*/
			fitTo:function(vehicle){
				if(this.get("window_start") > this.get("window_end"))
					return false;
				var vehicle_types = this.get("vehicle_types");
				var types = vehicle.get("types");
				for(var key in vehicle_types){
					if(types[key]==undefined || vehicle_types[key].indexOf(types[key]) == -1){
						return false;
					}
				}
				return true;
			}
		});

/**
* This function sets the area bounds and the markers within
*@method model
*@param attrs {} The attribute of the parcel
*@param options {} options for the parcel
*@return true {boolean} returns true if the vehicle type exists
*/
var Parcels = SuperModel.Collection.extend({
	model : function(attrs, options) {
		return Parcel.create(attrs, options);
	},
/**
* This function gets the parcels selected in the area
*@method getSelectedParcels
*@param parcel {Parcel} uses the vehicle class to get types
*@return true {boolean} returns true parcels are selected
*/
	url : site.urlTo("parcels") + "?date=" + getParameterByName("date"),
	getSelectedParcels : function() {
		return this.search(function(parcel) {
			return !empty(parcel.marker) && parcel.marker.map != null
					& parcel.get("selected");
		});
	},
/**
* This function gets the parcels selected by volume
*@method getSelectedTotalVolume
*@return true {boolean} returns true if parcels are selected 
*/
	getSelectedTotalVolume : function() {
		return this.getSelectedParcels().reduce(function(memo, parcel) {
			return memo + parseFloat(parcel.get("volume"));
		}, 0);
	},
/**
* This function gets the parcels selected by weight
*@method getSelectedTotalWeight
*@return true {boolean} returns  iftrue parcels are selected 
*/
	getSelectedTotalWeight : function() {
		return this.getSelectedParcels().reduce(function(memo, parcel) {
			return memo + parseFloat(parcel.get("weight"));
		}, 0);
	},
/**
* This function gets the parcels that are unassigned
*@method getIdleParcels
*@return true {boolean} returns  iftrue parcels are selected 
*/
	getIdleParcels : function() {
		return this.getVisibleModels().search(function(parcel) {
			return parcel.get("vehicle_id") == "";
		});
	}
});
/**
* This function sets the area bounds and the markers within
*@method getPosition
*@return latlng {LatLng} returns the coordinates of the driver
*/
// Vehicle
var Vehicle = SuperModel.Model.extend({
	name : "vehicle",
	getPosition : function() {
		return new google.maps.LatLng(this.driver().get('lat'), this.driver()
				.get('lng'));
	},
/**
* This function gets the capacity Volume left
*@method getCapacityVolumeLeft
*@return true {Parcel} returns the parcel with the volume left
*/
	getCapacityVolumeLeft : function() {
		return this.get("capacity_volume")
				- this.parcels().search(function(parcel) {
					return parcel.marker.map != null;
				}).reduce(function(memo, parcel) {
					return memo + parcel.get("volume");
				}, 0);
	},
/**
* This function gets the capacity Weight left
*@method getCapacityWeightLeft
*@return memo + parcel {Parcel} returns the parcel with the weight left
*/
	getCapacityWeightLeft : function() {
		return this.get("capacity_weight")
				- this.parcels().search(function(parcel) {
					return parcel.marker.map != null;
				}).reduce(function(memo, parcel) {
					return memo + parcel.get("weight");
				}, 0);
	},
/**
* This function gets the capacity Weight left
*@method getColor
*@return hexColor{String} returns the hexColor of the vehicle
*/
	getColor : function() {
		return hexColor(this.id);
	}
});
var Vehicles = SuperModel.Collection.extend({
	model : function(attrs, options) {
		return Vehicle.create(attrs, options);
	},
	url : site.urlTo("vehicles")
});

// Driver
var Drivers = SuperModel.Collection.extend({
	model : function(attrs, options) {
		return Driver.create(attrs, options);
	},
	url : site.urlTo("drivers")
});

var Driver = SuperModel.Model.extend({
	name : "driver",
});

// Profile
var Profile = SuperModel.Model.extend({
	name : "profile",
	url : site.urlTo("profiles/my-profile"),
});

// Relations
Vehicle.has().many('parcels', {
	collection : Parcels,
	inverse : 'vehicle'
});

Parcel.has().one('vehicle', {
	model : Vehicle,
	inverse : 'parcels'
});

Vehicle.has().one('driver', {
	model : Driver,
	inverse : 'vehicle'
});
