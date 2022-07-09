@extends('admin.layout')
@section('body')
	<style>
		#map { height: 480px; }
	</style>
	<div class="row state-overview">
      	<div class="col-lg-3 col-sm-6">
          	<section class="panel">
              	<div class="symbol terques">
                  	<i class="fa fa-user"></i>
              	</div>
              	<div class="value">
                  	<h1 class="count">
                      0
                  	</h1>
                  	<p>New Users</p>
              	</div>
          	</section>
      	</div>
      	<div class="col-lg-12">
      		<div id="map" style="height:700px"></div>
      		{{ $el }}
      	</div>
  	</div>
  	@section('scripts')
  		<script>
  			function markerOnClick(e){
			  console.log("Las coordenadas son:" + e.latlng);
			}
  			$(document).ready(function() {
  				var map = L.map('map').setView([40.5, -3.7], 6);
  				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				    maxZoom: 19,
				    attribution: '© OpenStreetMap',
				}).addTo(map);
				map.on('pm:create', (e) => {
				  e.layer.setStyle({ pmIgnore: false });
				  L.PM.reInitLayer(e.layer);
				});
				map.pm.addControls({  
				  	position: 'topleft',  
				  	drawCircle: false,  
				});
				@php
					$cl = 0;
				@endphp
				@foreach($el as $ele)
						var myIcon = L.icon({
							@if($ele->tipo == 1)
						    iconUrl: 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/62/Color_negro.jpg/1200px-Color_negro.jpg',
						    @elseif($ele->tipo == 0)
						    	iconUrl: 'https://www.clipartmax.com/png/full/360-3607544_lamp-post-vector-poste-de-luz-icon.png',
						    @else
						    	iconUrl: 'https://toppng.com/uploads/preview/map-point-google-map-marker-gif-11562858751s4qufnxuml.png',
						    @endif
						    iconSize: [18, 15],
						    iconAnchor: [22, 94],
						    popupAnchor: [-12, -85],
						    // shadowUrl: 'my-icon-shadow.png',
						    shadowSize: [68, 95],
						    shadowAnchor: [22, 94],
						});

						L.marker([{{ $ele->latitud }}, {{ $ele->longitud }}], {icon: myIcon}).bindPopup('<span><b>{{ $ele->nombre }}</b></span><br><span>Latitud: {{ $ele->latitud }}</span><br><span>Longitud: {{ $ele->longitud }}</span>').on('click', markerOnClick).addTo(map);


				@endforeach

				// var imageUrl = 'https://maps.lib.utexas.edu/maps/historical/newark_nj_1922.jpg',
    // 			imageBounds = [[40.32234,-3.86496],[40.42378, -3.56129]];
				// L.imageOverlay(imageUrl, imageBounds , {
				// 	opacity:0.7
				// }).addTo(map);
  			});
  		</script>
  	@endsection
@stop