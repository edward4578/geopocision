@extends('layouts.app')

@section('content')
<div class="container">
	<div id="menu" class="form-control">
		<input id="streets-v11" type="radio" name="rtoggle" value="streets" checked="checked"/>
		<label for="streets">Calles</label>
		<input id="light-v10" type="radio" name="rtoggle" value="light" />
		<label for="light">Ligero</label>
		<input id="dark-v10" type="radio" name="rtoggle" value="dark" />
		<label for="dark">Oscuro</label>
		<input id="outdoors-v11" type="radio" name="rtoggle" value="outdoors" />
		<label for="outdoors">al aire libre</label>
		<input id="satellite-v9" type="radio" name="rtoggle" value="satellite" />
		<label for="satellite">satelite</label>
	</div>
	<div id="map" class="map"></div>
</div>

@endsection

@section('script')
<script>
	mapboxgl.accessToken = 'pk.eyJ1IjoiZWRkNDU3OCIsImEiOiJjazc1YzRjbXMweDgyM25vbnl0ZHB2aG55In0.LW2hDHXuscy3MfU5fs5qgQ';

	var map = new mapboxgl.Map({
		container: 'map',
		style: 'mapbox://styles/mapbox/streets-v11'
	});
		//busqueda de punto A á punto B
		var directions = new MapboxDirections({
			accessToken: mapboxgl.accessToken,
			steps: false,
			geometries: 'true',
			alternatives: false,
			controls: { instructions: true }
		});
		map.addControl(directions, 'top-right');
		
		//menu de tipo de Mapa
		var layerList = document.getElementById('menu');
		var inputs = layerList.getElementsByTagName('input');

		function switchLayer(layer) {
			var layerId = layer.target.id;
			map.setStyle('mapbox://styles/mapbox/' + layerId);
		}

		for (var i = 0; i < inputs.length; i++) {
			inputs[i].onclick = switchLayer;
		}

		//idioma del mapa de acuerdo al idioma del navegador
		mapboxgl.setRTLTextPlugin('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.1.0/mapbox-gl-rtl-text.js');
		map.addControl(new MapboxLanguage());


		
		//creacion de ruta con puntos 	
		map.on('load', function() {
			map.addSource('route', {
				'type': 'geojson',
				'data': {
					'type': 'Feature',
					'properties': {},
					'geometry': {
						'type': 'LineString',
						'coordinates': [
						[-122.48369693756104, 37.83381888486939],
						[-122.48348236083984, 37.83317489144141],
						[-122.48339653015138, 37.83270036637107],
						[-122.48356819152832, 37.832056363179625],
						[-122.48404026031496, 37.83114119107971],
						[-122.48404026031496, 37.83049717427869],
						[-122.48348236083984, 37.829920943955045],
						[-122.48356819152832, 37.82954808664175],
						[-122.48507022857666, 37.82944639795659],
						[-122.48610019683838, 37.82880236636284],
						[-122.48695850372314, 37.82931081282506],
						[-122.48700141906738, 37.83080223556934],
						[-122.48751640319824, 37.83168351665737],
						[-122.48803138732912, 37.832158048267786],
						[-122.48888969421387, 37.83297152392784],
						[-122.48987674713133, 37.83263257682617],
						[-122.49043464660643, 37.832937629287755],
						[-122.49125003814696, 37.832429207817725],
						[-122.49163627624512, 37.832564787218985],
						[-122.49223709106445, 37.83337825839438],
						[-122.49378204345702, 37.83368330777276]
						]
					}
				}
			});
			//tipo de Layers pinstado en mapa
			map.addLayer({
				'id': 'route',
				'type': 'line',
				'source': 'route',
				'layout': {
					'line-join': 'round',
					'line-cap': 'round'
				},
				'paint': {
					'line-color': '#888',
					'line-width': 8
				}
			});
		});
		Console.log(map);
	</script>
	@endsection
