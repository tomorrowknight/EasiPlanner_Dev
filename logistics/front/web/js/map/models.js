//Author: Evan Lee, Email: chief725@gmail.com

var SuperModel = {
		Model : Supermodel.Model.extend({
			name : "",
			urlRoot : function() {
				return site.urlTo(this.name + 's');
			},
			initialize : function() {
				Supermodel.Model.prototype.initialize.apply(this, arguments);
				this.boot();
			},
			createMarker : function(map) {
				this.map = map;
				this.marker = new google.maps.Marker({
					position : this.getPosition(),
					map : map,
					model : this
				});
				this.marker.setIcon(this.getIcon());
			},
			addDeliveryStatusMarker: function(location, map, status) {
				// Add the marker at the clicked location, and add the next-available label
				// from the array of alphabetical characters.
				this.map = map;
				var delivered = "green";
				var failed = "orange";
				var rejected = "red";
				var baseURL = "http://maps.google.com/mapfiles/ms/icons/"
				var labelChar =' ';	
				if(status==1){
					labelChar = 'D';
					var icon = baseURL + delivered + ".png";
				}else if (status==2){
					labelChar = 'R';
					var icon = baseURL + rejected + ".png";	
				}else if(status==3){
					labelChar = 'F';
					var icon = baseURL + failed + ".png";	
				}
				this.marker = new google.maps.Marker({
					position: this.getPosition(),
					label: labelChar,
					map: map,
					labelAnchor: new google.maps.Point(3, 50),
					model: this,
					icon: new google.maps.MarkerImage(icon)
				});
			},
			getIcon : function() {
				return this.getIconUrl(this.id);
			},
			getIconUrl : function(index) {
				return site.urlTo("image/view?name=" + this.name + "&id=" + index);
			},
			getPosition : function() {
				return new google.maps.LatLng(this.get('lat'), this.get('lng'));
			},
			distance : function(model) {
				return google.maps.geometry.spherical.computeDistanceBetween(this
						.getPosition(), model.getPosition());
			},
			travelTime : function(model) {
				return this.distance(model) / 500;
			},
			boot : function() {
			},
			setMarkerIcon : function() {
			},
		}),
		Collection : Backbone.Collection.extend({
			triggerEach : function() {
				var args = Array.prototype.slice.call(arguments);
				func = args.shift();
				this.each(function(model) {
					model[func].apply(model, args);
				});
			},
			search : function(func) {
				return new this.constructor(this.filter(func));
			},
			getVisibleModels : function() {
				return this.search(function(parcel) {
					return !empty(parcel.marker) && !empty(parcel.marker.map);
				});
			}
		})
};

//Parcel
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
	getColor : function() {
		return hexColor(this.get("vehicle_id"));
	},
	getInvertColor : function() {
		return hexInvertColor(this.get("vehicle_id"));
	},
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
	getWindowStart : function() {
		return createDate(this.get("window_start")).getHours()
		+ new Date().getTimezoneOffset() / 60;
	},
	getWindowEnd : function() {
		return createDate(this.get("window_end")).getHours()
		+ new Date().getTimezoneOffset() / 60;
	},
	getWindowStartTime : function() {
		return parseDate(this.get("window_start")) / 60000;
	},
	getWindowEndTime : function() {
		return parseDate(this.get("window_end")) / 60000;
	},
	getLatestStartTime : function() {
		return this.getWindowEndTime() - this.get("service_time");
	},
	getServiceEndTime : function() {
		return this.get("planned_deliver_time")
		+ this.get("service_time");
	},
	getDeliverTime : function() {
		if(this.get(deliver.time != null)){
			return createDate(this.get("deliver_time")).getHours()
			+ new Date().getTimezoneOffset() / 60;
		}
	},
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
	onSelect : function(bounds, selected) {
		if (!empty(this.marker)
				&& bounds.contains(this.marker.getPosition())) {
			this.set('selected', selected);
		}
	},
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

var Parcels = SuperModel.Collection.extend({
	model : function(attrs, options) {
		return Parcel.create(attrs, options);
	},
	url : site.urlTo("parcels") + "?date=" + getParameterByName("date"),
	getSelectedParcels : function() {
		return this.search(function(parcel) {
			return !empty(parcel.marker) && parcel.marker.map != null
			& parcel.get("selected");
		});
	},
	getSelectedTotalVolume : function() {
		return this.getSelectedParcels().reduce(function(memo, parcel) {
			return memo + parseFloat(parcel.get("volume"));
		}, 0);
	},
	getSelectedTotalWeight : function() {
		return this.getSelectedParcels().reduce(function(memo, parcel) {
			return memo + parseFloat(parcel.get("weight"));
		}, 0);
	},
	getIdleParcels : function() {
		return this.getVisibleModels().search(function(parcel) {
			return parcel.get("vehicle_id") == "";
		});
	}
});

//Vehicle
var Vehicle = SuperModel.Model.extend({
	name : "vehicle",
	getPosition : function() {
		return new google.maps.LatLng(this.driver().get('lat'), this.driver()
				.get('lng'));
	},
	getCapacityVolumeLeft : function() {
		return this.get("capacity_volume")
		- this.parcels().search(function(parcel) {
			return parcel.marker.map != null;
		}).reduce(function(memo, parcel) {
			return memo + parcel.get("volume");
		}, 0);
	},
	getCapacityWeightLeft : function() {
		return this.get("capacity_weight")
		- this.parcels().search(function(parcel) {
			return parcel.marker.map != null;
		}).reduce(function(memo, parcel) {
			return memo + parcel.get("weight");
		}, 0);
	},
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

//Driver
var Drivers = SuperModel.Collection.extend({
	model : function(attrs, options) {
		return Driver.create(attrs, options);
	},
	url : site.urlTo("drivers")
});

var Driver = SuperModel.Model.extend({
	name : "driver",
});

//Profile
var Profile = SuperModel.Model.extend({
	name : "profile",
	url : site.urlTo("profiles/my-profile"),
});

//Relations
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
