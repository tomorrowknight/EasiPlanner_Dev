/**
* This the class for the Clark Wright Algorithm which is a key part of the application
*@class near
*@static
*@param depot {Depot} the depot or start location
*@param parcels {Parcel[]} the parcel and the information associated with it
*@param vehicles (Vehicle[]) the vecicles that will be used to form the routes
*@return routes (String) returns the route of the vehicle
*/
function clarkeRoute(depot, parcels, vehicles) {
	if (depot == null || parcels == null || parcels.length <= 1) {
		return [];
	}

	var matrix = [];
	for (var i = 0; i < parcels.length; i++) {
		for ( j = i + 1; j < parcels.length; j++) {
			var distance = parcels.at(i).distance(depot) + parcels.at(j).distance(depot) - parcels.at(i).distance(parcels.at(j));
			matrix.push({
				x : i,
				y : j,
				distance : distance
			});
		}
	}
	matrix.sort(function(a, b) {
		return b.distance - a.distance;
	});


	var visited = [];
	var routes = [];
	while (visited.length != parcels.length) {
		var vehicle = vehicles.shift();
		vehicles.push(vehicle);
		var indexs = [];

		vehicle.left_volume = vehicle.get("capacity_volume");
		vehicle.left_weight = vehicle.get("capacity_weight");
		for (var i = 0; i < matrix.length; i++) {
			function visit(index, push) {
				var parcel = parcels.at(index);
				if (visited.indexOf(index) >= 0) {
					return;
					//visited? skip.
				}
				if (vehicle.left_volume < parcel.get("volume") || vehicle.left_weight < parcel.get("weight")) {
					return;
					// overloaded? skip.
				};

				if (push) {
					indexs.push(index);
				} else {
					indexs.unshift(index);
				}
				
				//update vehicle capacity
				vehicle.left_volume -= parcel.get("volume");
				vehicle.left_weight -= parcel.get("weight");
				
				// remove saving.
				saving.distance = 0;
				
				//mark as visited
				visited.push(index);
				
				// restart loop
				i = -1;
			}

			var saving = matrix[i];
			if (saving.distance == 0)
				continue;

			if (indexs.length == 0) {
				if (visited.indexOf(saving.y) == -1 && visited.indexOf(saving.x) == -1) {
					visit(saving.x, true);
					visit(saving.y, true);
				}
			} else if (saving.x == indexs[0]) {
				visit(saving.y, false);
			} else if (saving.y == indexs[0]) {
				visit(saving.x, false);
			} else if (saving.x == indexs[indexs.length - 1]) {
				visit(saving.y, true);
			} else if (saving.y == indexs[indexs.length - 1]) {
				visit(saving.x, true);
			}
		}

		if (indexs.length == 0)
			break;

		var route = {
			vehicle : vehicle,
			indexs : indexs
		};

		route.parcels = _.map(route.indexs, function(i) {
			return parcels.at(i);
		});
		routes.push(route);
	}

	return routes;
}
