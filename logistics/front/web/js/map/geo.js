function geocode(country, postal_code,callback) {
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode({
		'address' : country + " " + postal_code,
		'componentRestrictions' : {country:country, postalCode:postal_code}
	}, function(results, status) {
		callback(results,status);
		return;
		if(results == null || results.length == 0){
			return;
		}
		window.results = results;
		var latLng = results[0].geometry.location;
		if (status == google.maps.GeocoderStatus.OK) {
			if(typeof callback !== "undefined"){
				callback(latLng.lat(),latLng.lng());
			}
		}
	});
}