/**
* This the class for the core algorithm of the application
*@class tsptw
*@static
*@param depot {Depot} the depot or start location
*@param parcels {Parcel[]} the parcel and the information associated with it
*@param vehicles (Vehicle[]) the vecicles that will be used to form the routes
*@param anchor (Coordinate) the point of reference from which the heuristic will base the next plotting of points on 
*@return routes (String) returns the route of the vehicle
*/
function tsptw(depot, parcels, vehicles, anchor) {
	var routes = [];
	var depotParcel = createDepotParcel(depot);

	var avgVolume = parcels.reduce(function(memo,parcel){return memo+parcel.get("volume");},0)/parcels.length;
	var avgWeight = parcels.reduce(function(memo,parcel){return memo+parcel.get("weight");},0)/parcels.length;
	
	parcels.each(function(p) {
		p.set("planned_deliver_time", null);
		p.set("visited", null);
	});
	parcels = parcels.reject(function(parcel){
		for(var i in vehicles){
			if(parcel.fitTo(vehicles[i]))
				return false;
		}
		return true;
	});
	
	while (parcels.length > 0) {
		var vehicle = vehicles.shift();
		vehicles.push(vehicle);
		vehicle.left_volume = vehicle.get("capacity_volume");
		vehicle.left_weight = vehicle.get("capacity_weight");
		
		var maxNumParcels = 10;
		
		var ps = [];
		ps.push(depotParcel);
		ps.push(depotParcel);
		
		
		while (true) {
			var inserted = false;
			
			if (anchor == null) {
				var center = getCenter(ps, depotParcel, parcels);
				var sortedParcels = _.sortBy(parcels,function(parcel) {
					return parcel.distance(center);
				});
			} else {
				var sortedParcels = _.sortBy(parcels,function(parcel) {
					return parcel.distance(anchor);
				});
			}
			sortedParcels = _.reject(sortedParcels, function(parcel){
				return !parcel.fitTo(vehicle);
			});
			sortedParcels = sortedParcels.slice(0,maxNumParcels);
			_.each(sortedParcels, function(parcel) {
				if (vehicle.left_volume < parcel.get("volume") || vehicle.left_weight < parcel.get("weight")) {
					return;
				}

				var orderBySavingIndexs = calIndexsBySavings(parcel, ps);
				for (var i = 0; i < orderBySavingIndexs.length; i++) {
					var orderBySavingIndex = orderBySavingIndexs[i];
					var ps_clone = _.map(ps, function(p) {
						return p.clone();
					});
					if (insertParcel(ps_clone, orderBySavingIndex, parcel.clone())) {
						insertParcel(ps, orderBySavingIndex, parcel);
						parcel.set("visited", true);
						parcels.remove(parcel);
						//update vehicle capacity
						vehicle.left_volume -= parcel.get("volume");
						vehicle.left_weight -= parcel.get("weight");
						inserted = true;
						break;
					};
				}
			});
			if (!inserted)
				break;
		}

		ps.pop();
		ps.shift();

		var route = {
			vehicle : vehicle,
			parcels : ps,
			id:new Date().getTime()
		};
		
		if(anchor!=null){
			return route; // only one route.
		}
		
		routes.push(route);
	}
	printRoutes(routes);
	return routes;
}

Array.prototype.remove = function(val) {
	var index = this.indexOf(val);
	if (index > -1) {
		this.splice(index, 1);
	}
    return this;
}
/**
* This the method to get the centroid of the depot and parcels and reference parcel
*@method getCentre
*@param ps {Parcel[]} parcels at the depot
*@param depotParcel {Parcel} the parcels at the depot or start location
*@param parcels {Parcel[]} the parcel and the information associated with it
*@return center (String) returns the centre coordinates of the routes based on the depot
*/
function getCenter(ps, depotParcel, parcels) {
	if (ps.length == 2) {
		return _.max(parcels,function(p) {
			return p.get("visited") ? 0 : p.distance(depotParcel);
		});
	}
	ps.pop();
	ps.shift();
	var centerSum = _.reduce(ps, function(memo, p) {
		return {
			lat : memo.lat + p.get("lat"),
			lng : memo.lng + p.get("lng")
		};
	}, {
		lat : 0,
		lng : 0
	});
	var center = new Parcel;
	center.set("lat", centerSum.lat / ps.length);
	center.set("lng", centerSum.lng / ps.length);
	ps.unshift(depotParcel);
	ps.push(depotParcel);
	return center;
}
/**
* This the class for the core algorithm of the application
*@class tsptw
*@static
*@param routes {Parcel[]} prints the route for each parcel
*/
function printRoutes(routes) {
	return;
	_.each(routes, function(route) {
		console.log("================================");
		_.each(route.parcels, function(parcel) {
			var tmpl = "<%=obj.get('customer_name')%>\t<%=obj.get('window_start')%>\t\t<%=obj.get('window_end')%>\t\t<%=obj.get('service_time')%>\t\t<%=new Date(obj.get('planned_deliver_time')*60000)%>";
			//console.log(_.template(tmpl)(parcel).toString());
		});
	});
}

/**
* This the class for the core algorithm of the application
*@method calIndexsBySavings
*@param parcel {Parcel} the parcel to compare the time saving to
*@param ps {Parcel[]} prints the route for each parcel
*@return {Number} the index of the pair of parcels which results in a saving
*/
function calIndexsBySavings(parcel, ps) {
	var savingPairs = [];
	for (var i = 0; i < ps.length - 1; i++) {
		savingPairs.push({
			index : i,
			saving : matrix.travelTime(parcel,ps[i],ps[i].getWindowStart()) + matrix.travelTime(parcel,ps[i + 1],ps[i+1].getWindowStart()) - matrix.travelTime(ps[i],ps[i + 1],ps[i+1].getWindowStart())
		});
	}
	savingPairs = _.sortBy(savingPairs, function(savingPair) {
		return savingPair.saving;
	});
	return _.map(savingPairs, function(savingPair) {
		return savingPair.index;
	});
}
/**
* This the class for the core algorithm of the application
*@method insertParcel
*@param ps_clone {Parcel[]} creates a clone array for the ps
*@param index {Number} the index of each savingPair
*@param parcel {Parcel} the parcel to compare with
*@return {boolean} returns true if a parcel can be inserted into the route
*/
function insertParcel(ps_clone, index, parcel) {
	ps_clone.splice(index + 1, 0, parcel);
	for (var i = index + 1; i < ps_clone.length - 1; i++) {
		var newStartTime = Math.max(ps_clone[i - 1].getServiceEndTime() + matrix.travelTime(ps_clone[i - 1], ps_clone[i],ps_clone[i].getWindowStart()), ps_clone[i].getWindowStartTime());
		if (newStartTime == ps_clone[i].get("planned_deliver_time")) {
			return true;
		} else if (newStartTime > ps_clone[i].getLatestStartTime()) {
			return false;
		}
		ps_clone[i].set("planned_deliver_time", newStartTime);
	}
	return true;
}

/**
* This the class for the core algorithm of the application
*@method createDepotParcel
*@param depot {Location} the location of the depot
*@return {Parcel} returns a generic parcel Object 
*/
function createDepotParcel(depot) {
	var parcel = new Parcel();
	parcel.set("window_start", "2000-01-01");
	parcel.set("window_end", "2099-01-01");
	parcel.set("lat", depot.get("lat"));
	parcel.set("lng", depot.get("lng"));
	parcel.set("i",0);
	parcel.set("postal",depot.get("postal"));
	parcel.set("service_time", 0);
	parcel.set("planned_deliver_time", parcel.getWindowStartTime());
	return parcel;
}