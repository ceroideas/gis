@extends('admin.layout')
@section('body')
	<style>
		#map { height: 480px; }
		.leaflet-pm-toolbar.leaflet-pm-draw.leaflet-bar.leaflet-control,
		.leaflet-pm-toolbar.leaflet-pm-edit.leaflet-bar.leaflet-control {
			display: none;
		}
		.blockUI.blockMsg.blockPage
		{
			z-index: 10011 !important;
		}
		.blockUI.blockOverlay
		{
			z-index: 10000 !important;
		}

		#textDraw {
			position: absolute;
		    width: 400px;
		    border: 2px solid #2a3542;
		    border-radius: 4px;
		    padding: 8px;
		    left: 0;
		    right: 0;
		    bottom: 80px;
		    margin: auto;
		    z-index: 9998;
		    background-color: #fff;
		}
	</style>
	<div class="row state-overview" style="position: relative;">
      	{{-- <div class="col-12">
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
      	</div> --}}

      	<div class="col-12">
      		<div>
      			
      		<button class="btn btn-xs btn-info" onclick="$('.leaflet-pm-icon-polyline').click();
      		addText('Para crear un cable, seleccione un marcador y haga clic para empiezar a dibujar, luego siga haciendo clic... Para finaliar, haga clic en el ultimo punto creado.')">Crear Cable</button>
      		
      		<button class="btn btn-xs btn-success" onclick="$('.leaflet-pm-icon-rectangle').click();
      		addText('Coloque el cursor donde desee crear la caja y luego arrastre para cambiar el tamaño y haga clic para terminar de crear.')">Caja</button>
      		
      		<button class="btn btn-xs btn-warning" onclick="$('.leaflet-pm-icon-polygon').click();
      		addText('Para crear un polígono, seleccione un marcador para empezar, arrastre el cursor y haga clic con distintos puntos, para finalizar haga clic en el primer punto creado.')">Polígono Cerrado</button>
      		
      		<button class="btn btn-xs btn-danger" onclick="$('.leaflet-pm-icon-edit').click();
      		addText('Haga clic en el borde de un elemento y arrastre para volver a posicionar, haga clic derecho para eliminar la capa creada.')">Editar Capas</button>

      		<button class="btn btn-xs btn-primary" id="openOverlay">Imagen Sobrepuesta</button>


      		<button class="btn btn-xs btn-danger" onclick="$('.leaflet-pm-icon-delete').click();
      		addText('Seleccione un elemento para borrarlo.')">Borrar</button>


      		</div>

      		<br>

      		<div id="map" style="height:700px"></div>
      		{{-- {{ $el }} --}}
      	</div>

	  	<div id="textDraw" style="display: none;">
	  		
	  	</div>
  	</div>


  	<div class="modal fade" id="addOverlay">
  		<div class="modal-dialog modal-md">
  			<form class="modal-content" id="overlay-form" method="POST">

  				{{csrf_field()}}
  				
  				<div class="modal-header">Agregar Overlay de Imagen</div>

  				<div class="modal-body">
  					<div class="row">
  						<div class="col-sm-6">
  							<div class="form-group">
		  						<label>Latitud Inicio</label>
		  						<input type="text" class="form-control" value="37.479972" name="stLat" required>
		  					</div>
  						</div>

  						<div class="col-sm-6">
  							<div class="form-group">
		  						<label>Longitud Inicio</label>
		  						<input type="text" class="form-control" value="-3.963486" name="stLon" required>
		  					</div>
  						</div>

  						<div class="col-sm-6">
  							<div class="form-group">
		  						<label>Latitud Final</label>
		  						<input type="text" class="form-control" value="37.444759" name="fnLat" required>
		  					</div>
  						</div>

  						<div class="col-sm-6">
  							<div class="form-group">
		  						<label>Longitud Final</label>
		  						<input type="text" class="form-control" value="-3.884579" name="fnLon" required>
		  					</div>
  						</div>

  						<div class="col-sm-6">
  							<div class="form-group">
		  						<label>Opacidad</label>
		  						<input type="number" min=0 step="0.1" value="0.7" class="form-control" name="opacity" required>
		  					</div>
  						</div>

  						<div class="col-sm-6">
  							<div class="form-group">
		  						<label>Imagen</label>
		  						<input type="file" class="form-control" name="image" required>
		  					</div>
  						</div>

  						<div id="preview" style="text-align: center;">
  							
  						</div>
  					</div>
  				</div>

  				<div class="modal-footer">
  					<button type="button" id="sendOverlay" class="btn btn-xs btn-success">Aceptar</button>
  					<button data-dismiss="modal" type="button" class="btn btn-xs btn-danger">Cancelar</button>
  				</div>

  			</form>
  		</div>
  	</div>
  	@section('scripts')
  		<script>
  			var overlay = null;
  			var overlayImage = false;
  			var map;
  			var layers = [];
  			function markerOnClick(e){
			  console.log("Las coordenadas son: " + e.latlng);
			  console.log(e);
			}
  			$(document).ready(function() {
  				map = L.map('map').setView([ {{isset($el[0]) ? $el[0]->latitud : '40.5'}}, {{isset($el[0]) ? $el[0]->longitud : '-3.7'}}], 14);
  				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				    maxZoom: 24,
				    attribution: '© IPS Gestión',
				}).addTo(map);

				map.on('pm:create', (e) => {
				  e.layer.setStyle({ pmIgnore: false });
				  L.PM.reInitLayer(e.layer);
				  console.log(e.layer.getLatLngs())
				  console.log(e);

				  let layer = e.layer;

				  layer.on('pm:edit', (e)=>{
				  	console.log(e);
				  })
				  layers.push({layer:e.layer});
				});
				map.on('layerremove', (e) => {
					if (e.layer.options.type == 'imageOverlay') {
						overlayImage = false;
					}
				})
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
						    iconSize: [18, 18],
						    iconAnchor: [9, 9],
						    popupAnchor: [0, -9],
						    // shadowUrl: 'my-icon-shadow.png',
						    // shadowSize: [68, 95],
						    // shadowAnchor: [18, 18],
						});

						L.marker([{!! $ele->latitud !!}, {!! $ele->longitud !!}], {icon: myIcon}).bindPopup('<span>Tipo: {{ $ele->tipo == 1 ? 'Arqueta' : ($ele->tipo == 0 ? 'Poste' : 'Armario') }}</span><br><span><b>{{ $ele->nombre }}</b></span><br><span>Latitud: {{ $ele->latitud }}</span><br><span>Longitud: {{ $ele->longitud }}</span>').on('click', markerOnClick).addTo(map);


				@endforeach

				var image;

				$('[name="image"]').change(function (e) {
					const preview = document.querySelector('img');
					const file = document.querySelector('input[type=file]').files[0];
					const reader = new FileReader();

					reader.addEventListener("load", function () {
					  // convierte la imagen a una cadena en base64
					  $('#preview').html(`<img src="${reader.result}" alt="" style="width:40%; border-radius: 4px">`);
					}, false);

					if (file) {
					    reader.readAsDataURL(file);
					}
				});

				$('#sendOverlay').click(function (e) {
					e.preventDefault();
					addLayer();
				});

				$('#openOverlay').click(function(event) {
					/* Act on the event */
					if (overlayImage) {
						alert('Ya hay una imagen overlay cargada!');
					}
					else
					{
						$('#addOverlay').modal('show');
					}
				});

				function addLayer()
				{
					$.blockUI({message:"<small>Subiendo Imagen...</small>"});
					let formData = new FormData($('#overlay-form')[0]);

					$.ajax({
						url: '{{url('uploadOverlay')}}',
						type: 'POST',
						contentType: false,
						processData: false,
						data: formData,
					})
					.done(function(data) {

						overlayImage = true;

						$('#addOverlay').modal('hide');

						$.unblockUI();

						$('#overlay-form')[0].reset();

						$('#preview').html("");
						
						var imageUrl = data.url,
		    			imageBounds = [[data.stLat,data.stLon],[data.fnLat,data.fnLon]];
						overlay = L.imageOverlay(imageUrl, imageBounds , {
							type: 'imageOverlay',
							interactive: true,
							opacity:data.opacity
						}).addTo(map);
					})
					.fail(function() {
						console.log("error");
					})
					.always(function() {
						console.log("complete");
					});
					
				}
  			});

  			function addText(t)
  			{
  				let td = $('#textDraw');

  				td.text(t);

  				td.show();
  			}

  				/*var imageUrl = '{{url('layer.jpg')}}',
    			imageBounds = [[37.479972,-3.963486],[37.444759, -3.884579]];
				overlay = L.imageOverlay(imageUrl, imageBounds , {
					interactive: true,
					opacity:0.7
				}).addTo(map);*/
  		</script>
  		<link rel="stylesheet" href="https://jquery.malsup.com/block/block.css?v3">
  		<script src="https://malsup.github.io/jquery.blockUI.js"></script>
  	@endsection
@stop