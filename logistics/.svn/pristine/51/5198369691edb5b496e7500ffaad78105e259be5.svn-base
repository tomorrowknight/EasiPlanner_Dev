function near(depot, parcels, vehicles, anchor) {
	var routes = [];
	var depotParcel = createDepotParcel(depot);

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
		
		var ps = [];
		ps.push(depotParcel);
		
		while (true) {
			var inserted = false;
			var lastParcel = ps[ps.length-1];
			var sortedParcels = _.sortBy(parcels,function(parcel) {
				var Dij = matrix.travelTime(lastParcel, parcel, lastParcel.get("planned_deliver_time")/60);
				var Tij = parcel.getWindowStartTime() - lastParcel.get("planned_deliver_time");
				var Sij = parcel.getLatestStartTime() - lastParcel.get("planned_deliver_time");
				return Dij * 0.4 + Tij * 0.4 + Sij * 0.2;
				return parcel.distance(lastParcel);
			});
			sortedParcels = _.reject(sortedParcels, function(parcel){
				return !parcel.fitTo(vehicle);
			});
			for(var i=0;i<sortedParcels.length;i++){
				parcel = sortedParcels[i];
				if (vehicle.left_volume > parcel.get("volume") && vehicle.left_weight > parcel.get("weight")) {
					var newStartTime = lastParcel.getServiceEndTime() + matrix.travelTime(lastParcel, parcel,parcel.getWindowStart());
					if (newStartTime > parcel.getLatestStartTime()) {
						continue;
					}
					parcel.set("planned_deliver_time", Math.max(newStartTime,parcel.getWindowStartTime()));
					ps.push(parcel);
					parcels.remove(parcel);
					vehicle.left_volume -= parcel.get("volume");
					vehicle.left_weight -= parcel.get("weight");
					inserted = true;
					break;
				}
			};
			if (!inserted)
				break;
		}

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
