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

      		<div id="map" style="height:550px"></div>
      		<div style="width: 100%;height: 550px;background: #999;position: absolute;top: 41px;z-index: 9999;display: flex;align-items: center;" id="loader_map">
      			<p style="margin: auto;color: #fff;font-size: 2em;">Cargando data...</p>
      		</div>
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

			function loadDataRed(red){
				if(map){
					map.off();
					map.remove();
				}
				$.ajax({
					url: '{{ url('/admin/load-red-data-to-map') }}/'+red,
					type: 'GET',
					data: {},
				})
				.done(function(data) {
					var ltm = '';
					var lnm = '';

					if(data.coo.latitud_google){
						ltm = data.coo.latitud_google;
						lnm = data.coo.longitud_google;
					}else if(data.coo.latitud){
						ltm = data.coo.latitud;
						lnm = data.coo.longitud;
					}
					map = L.map('map').setView([ltm , lnm], 14);
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

					$.each(data.nod, function(index, val) {
						var myIcon = L.icon({
							iconUrl:'https://app.apx-gis.com/icon/icon-eb2a649b-db9f-3ba1-f197-cf806f5.png',
						    iconSize: [20, 20],
						    iconAnchor: [9, 9],
						    popupAnchor: [0, -9],
						});
						var ln = '';
						var lt = '';
						if(val.latitud_google){
							lt = val.latitud_google;
						}
						if(val.longitud_google){
							ln = val.longitud_google;
						}
						L.marker([lt, ln], {icon: myIcon}).bindPopup('<span><b>Nodo Central</b></span><br><span><b>'+val.nombre+'</b></span><br><span>Latitud:'+lt+'</span><br><span>Longitud:'+ln+'</span>').on('click', markerOnClick).addTo(map);
					});

					$.each(data.box, function(index, val) {
						var myIcon = L.icon({
							iconUrl:'https://app.apx-gis.com/icon/icon-14d37a8e-353b-c947-4448-8ae397d.png',
						    iconSize: [20, 20],
						    iconAnchor: [9, 9],
						    popupAnchor: [0, -9],
						});
						var ln = '';
						var lt = '';
						if(val.latitud){
							lt = val.latitud;
						}
						if(val.longitud){
							ln = val.longitud;
						}
						L.marker([lt, ln], {icon: myIcon}).bindPopup('<span><b>Caja</b></span><br><span><b>'+val.nombre+'</b></span><br><span>Latitud:'+lt+'</span><br><span>Longitud:'+ln+'</span>').on('click', markerOnClick).addTo(map);
					});

					$.each(data.spi, function(index, val) {
						var myIcon = L.icon({
							iconUrl:'https://app.apx-gis.com/icon/icon-8607b979-b55a-8475-238d-3dba822.png',
						    iconSize: [20, 20],
						    iconAnchor: [9, 9],
						    popupAnchor: [0, -9],
						});
						var ln = '';
						var lt = '';
						if(val.latitud){
							lt = val.latitud;
						}
						if(val.longitud){
							ln = val.longitud;
						}
						L.marker([lt, ln], {icon: myIcon}).bindPopup('<span><b>Caja</b></span><br><span><b>'+val.nombre+'</b></span><br><span>Latitud:'+lt+'</span><br><span>Longitud:'+ln+'</span>').on('click', markerOnClick).addTo(map);
					});


					setTimeout(function(){
						$('#loader_map').hide();
					},1000);
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
			}

  			$(document).ready(function() {
				loadDataRed('{{ $red->id }}');
				$(document).on('click' , '.item_load' , function(){
					$('.item_load').removeClass('active');
					$(this).addClass('active');
					$('#loader_map').show();
					loadDataRed($(this).data('id'));
				});

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