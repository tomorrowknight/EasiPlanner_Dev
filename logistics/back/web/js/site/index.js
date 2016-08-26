var rootContext = document.body.getAttribute("data-root");

function switchLayer() {
	var checkedLayer = $('#layerswitcher input[name=layer]:checked').val();
	for (i = 0, ii = layers.length; i < ii; ++i)
		layers[i].setVisible(i == checkedLayer);
}
$(function() {
	switchLayer()
});
$("#layerswitcher input[name=layer]").change(function() {
	switchLayer()
});

function lnglat(lng, lat) {
	return ol.proj.transform([ parseFloat(lng), parseFloat(lat) ], 'EPSG:4326',
			'EPSG:3857');
}

var osm = new ol.layer.Tile({
	source : new ol.source.OSM()
});
var bing = new ol.layer.Tile(
		{
			source : new ol.source.BingMaps(
					{
						key : 'Ak-dzM4wZjSqTlzveKz5u0d4IQ4bRzVI309GxmkgSVr1ewS6iPSrOvOKhA-CJlm3',
						imagerySet : 'Road',
						maxZoom : 19
					})
		});
var layers = [ osm, bing ];
var map = new ol.Map({
	layers : layers,
	target : document.getElementById('map'),
	view : new ol.View({
		center : lnglat(103.82, 1.34),
		zoom : 12
	})
});

var popup = $('#popup');

var popupOverLay = new ol.Overlay({
	element : popup.get(0),
	positioning : 'bottom-center',
	stopEvent : false
});

map.addOverlay(popupOverLay);

map.on("click", function(evt) {
	var feature = map.forEachFeatureAtPixel(evt.pixel,
			function(feature, layer) {
				return feature;
			});
	if (feature) {
		popupOverLay.setPosition(feature.getGeometry().getCoordinates());
		popup.popover({
			'placement' : 'top',
			'html' : true,
			'content' : feature.get('phone')
		});
		popup.popover('show');
	} else {
		popup.popover('destroy');
	}
});

function plotMarkers(locs) {
	var iconFeatures = _.map(locs, function(loc) {
		return new ol.Feature({
			geometry : new ol.geom.Point(lnglat(loc.lng, loc.lat)),
			id : loc.id,
			phone : loc.phone
		});
	})

	var vectorLayer = new ol.layer.Vector({
		source : new ol.source.Vector({
			features : iconFeatures
		}),
		style : new ol.style.Style({
			image : new ol.style.Icon({
				src : rootContext + '/icon/marker-red.png'
			})
		})
	});

	map.addLayer(vectorLayer);
	map.addInteraction(new ol.interaction.Modify({
		features : new ol.Collection(iconFeatures)
	}));
}

$.getJSON(rootContext + "/locs.json", function(locs) {
	window.locs = locs;
	plotMarkers(locs);
});