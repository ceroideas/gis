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
      	<div class="col-lg-8">
  			<button class="btn btn-xs btn-info" onclick="$('.leaflet-pm-icon-polyline').click(); addText('Para crear un cable, seleccione un marcador y haga clic para empiezar a dibujar, luego siga haciendo clic... Para finaliar, haga clic en el ultimo punto creado.')">
  				Crear Cable
  			</button>
  			<button class="btn btn-xs btn-success" onclick="$('.leaflet-pm-icon-circle-marker').click(); addText('Coloque el cursor donde desee crear la caja y luego arrastre para cambiar el tamaño y haga clic para terminar de crear.')">
  				Crear caja
  			</button>
      		<button class="btn btn-xs btn-warning" onclick="$('.leaflet-pm-icon-polygon').click(); addText('Para crear un polígono, seleccione un marcador para empezar, arrastre el cursor y haga clic con distintos puntos, para finalizar haga clic en el primer punto creado.')">
      			Polígono Cerrado
      		</button>
      		<button class="btn btn-xs btn-danger" onclick="$('.leaflet-pm-icon-edit').click(); addText('Haga clic en el borde de un elemento y arrastre para volver a posicionar, haga clic derecho para eliminar la capa creada.')">
      			Editar Capas
      		</button>
  			<button class="btn btn-xs btn-primary" id="openOverlay">
  				Imagen Sobrepuesta
  			</button>
  			<button class="btn btn-xs btn-danger" onclick="$('.leaflet-pm-icon-delete').click(); addText('Seleccione un elemento para borrarlo.')">
  				Borrar
  			</button>
  		</div>
  		<div class="col-lg-4">
  			<select name="red_id" id="red-id" class="form-control select2">
  				<option value="">Seleccione red</option>
  				@foreach(DB::table('redes')->get() as $re)
  					<option value="{{ $re->id }}" {{ $red->id == $re->id ? 'selected' : '' }}>{{ $re->nombre }}</option>
  				@endforeach
  			</select>
  		</div>
  		<br>
  		<div class="col-lg-12">
  			<br>
	  		<div id="map" style="height:550px"></div>
	  		<div style="width: 100%;height: 550px;background: #999;position: absolute;top: 20px;z-index: 9999;display: flex;align-items: center;" id="loader_map">
	  			<p style="margin: auto;color: #fff;font-size: 2em;">Cargando data...</p>
	  		</div>
		  	<div id="textDraw" style="display: none;"></div>
  		</div>
  	</div>


  	<div class="modal fade" id="addOverlay">
  		<div class="modal-dialog modal-md">
  			<form class="modal-content" id="overlay-form" method="POST">
  				{{csrf_field()}}
  				<div class="modal-header">
  					Agregar Overlay de Imagen
  				</div>
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
  						<div id="preview" style="text-align: center;"></div>
  					</div>
  				</div>
  				<div class="modal-footer">
  					<button type="button" id="sendOverlay" class="btn btn-xs btn-success">Aceptar</button>
  					<button data-dismiss="modal" type="button" class="btn btn-xs btn-danger">Cancelar</button>
  				</div>
  			</form>
  		</div>
  	</div>

  	<div class="modal fade" id="add_element">
  		<div class="modal-dialog modal-md">
  			<form class="modal-content" id="add_element_form" method="POST">
  				{{csrf_field()}}
  				<div class="modal-header add_element_header"></div>
  				<input type="hidden" name="paths">
  				<input type="hidden" name="active_red">
  				<input type="hidden" name="type_element">
  				<input type="hidden" name="lt_element">
  				<input type="hidden" name="ln_element">
  				<div class="modal-body">
  					<div class="row">
  						<div class="col-sm-12">
  							<div class="form-group">
		  						<label>Descripcion</label>
		  						<textarea name="description" id="description" cols="30" rows="3" class="form-control"></textarea>
		  					</div>
  						</div>
  						<div class="col-sm-12">
  							<div class="form-group">
		  						<label>Tamaño</label>
		  						<input type="number" name="size" class="form-control" min="1">
		  					</div>
  						</div>
  					</div>
  				</div>
  				<div class="modal-footer">
  					<button type="button" id="send_new_element" class="btn btn-xs btn-success">Aceptar</button>
  					<button data-dismiss="modal" type="button" class="btn btn-xs btn-danger">Cancelar</button>
  				</div>
  			</form>
  		</div>
  	</div>
  	<div class="modal fade" id="edit_element">
  		<div class="modal-dialog modal-md">
  			<form class="modal-content" id="edit_element_form" method="POST">
  				{{csrf_field()}}
  				<div class="modal-header edit_element_header"></div>
  				<input type="hidden" name="element_id">
  				<div class="modal-body">
  					<div class="row">
  						<div class="col-sm-12">
  							<div class="form-group">
		  						<label>Descripcion</label>
		  						<textarea name="description" id="description_edit_element" cols="30" rows="3" class="form-control"></textarea>
		  					</div>
  						</div>
  					</div>
  				</div>
  				<div class="modal-footer">
  					<button type="button" id="send_edit_element" class="btn btn-xs btn-success">Aceptar</button>
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
			  // console.log("Las coordenadas son: " + e.latlng);
			  // console.log(e);
			}

			function saveElement(e){
				console.log(e);
				var path = [];
				if(e.shape == 'Line'){
					$('.add_element_header').text('Nuevo cable');
					$.each(e.marker._latlngs, function(index, val) {
						var ltln = [val.lat, val.lng];
						path.push(ltln);
					});
					$('[name="paths"]').val(JSON.stringify(path));
					$('[name="type_element"]').val('3');
				}
				if(e.shape == 'CircleMarker'){
					$('.add_element_header').text('Nueva caja');
					$('[name="type_element"]').val('0');
					$('[name="lt_element"]').val(e.layer._latlng.lat);
					$('[name="ln_element"]').val(e.layer._latlng.lng);
					$('.leaflet-pm-icon-circle-marker').click();
				}	
				$('#add_element').modal('show');
			}

			function showEditElementModal(s){
				$('[name="element_id"]').val(s.data('id'));
				$('#description_edit_element').val(s.data('name'));
				$('.edit_element_header').text(s.data('text'));

				$('#edit_element').modal('show');
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
					  	saveElement(e);

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
						L.marker([lt, ln], {icon: myIcon}).bindPopup('<span><b>Nodo Central</b></span><br><span style="cursor:pointer;color:blue;text-decoration:underline" onclick="showEditElementModal($(this))" data-id="'+val.id+'" data-name="'+val.nombre+'" data-text="Editar nodo"><b>'+val.nombre+'</b></span><br><span>Latitud:'+lt+'</span><br><span>Longitud:'+ln+'</span>').on('click', markerOnClick).addTo(map);
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
						L.marker([lt, ln], {icon: myIcon}).bindPopup('<span><b>Caja</b></span><br><span  style="cursor:pointer;color:blue;text-decoration:underline" onclick="showEditElementModal($(this))" data-id="'+val.id+'" data-name="'+val.nombre+'" data-text="Editar caja"><b>'+val.nombre+'</b></span><br><span>Latitud:'+lt+'</span><br><span>Longitud:'+ln+'</span>').on('click', markerOnClick).addTo(map);
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

					$.each(data.cab , function(index, val){
						var ltLn = JSON.parse(val.path);
						if(ltLn){
							var polyline = L.polyline(ltLn, {
								color: 'blue'
							}).bindPopup('<span><b>Cable</b></span><br><span><b>'+val.nombre+'</b></span>').on('click', markerOnClick).addTo(map);
						}
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
				$('[name="active_red"]').val('{{ $red->id }}');
				$(document).on('change' , '#red-id' , function(){
					var id = $(this).val();
					if(id){
						$('#loader_map').show();
						$('[name="active_red"]').val(id);
						loadDataRed(id);
					}
				});


				$(document).on('click' , '#send_new_element' , function(){
					var f =$('#add_element_form');
					$.ajax({
						url: '{{ url('/admin/save-new-element') }}',
						type: 'POST',
						data: f.serialize(),
					})
					.done(function(data) {
						console.log(data);
						alert('Elemento creado exitosamente');
						$('#add_element').modal('hide');
					})
					.fail(function() {
						console.log("error");
					})
					.always(function() {
						console.log("complete");
					});
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
  		</script>
  		<link rel="stylesheet" href="https://jquery.malsup.com/block/block.css?v3">
  		<script src="https://malsup.github.io/jquery.blockUI.js"></script>
  	@endsection
@stop