@extends('admin.layout')
@section('body')
	<div class="row state-overview" style="position: relative;">
		<div class="col-lg-12">
			<h4>
				Plantillas registradas
			</h4>
		</div>
		<div class="col-lg-12">
			<div class="card-body-table">
				<button class="btn btn-success" data-target="#new_tc" data-toggle="modal">
					Nueva plantilla
				</button> <br><br>
				@if(session()->has('msj'))
					<div class="alert alert-success text-center">
						{{ session()->get('msj') }}
					</div>
				@endif
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Plantilla</th>
							<th>Opciones</th>
						</tr>
					</thead>
					<tbody>
						@forelse($tc as $t_c)
							<tr>
								<td>
									{{ $t_c->codigo }}
								</td>
								</td>
								<td>
									<div class="btn-group">
										<button class="btn btn-xs btn-primary" data-target="#edit_tc_{{ $t_c->codigo }}" data-toggle="modal">
											Editar
										</button>
										<button class="btn btn-xs btn-info" data-target="#details_{{ $t_c->codigo }}" data-toggle="modal">
											Ver detalles
										</button>
										<button class="btn btn-xs btn-danger" data-target="#delete_tc_{{ $t_c->codigo }}" data-toggle="modal">
											Eliminar
										</button>
									</div>
									<div class="modal fade" id="details_{{ $t_c->codigo }}">
								  		<div class="modal-dialog modal-md">
								  			<div class="modal-content">
								  				<div class="modal-header">Plantilla {{ $t_c->codigo }}</div>
								  				<div class="modal-body">
								  					<div class="row">
								  						<div class="col-lg-12">
								  							<ul>
								  								<li>
								  									<b>Codigo:</b> {{ $t_c->codigo }}
								  								</li>
								  								<li>
								  									<b>N de fibras:</b> {{ $t_c->numero_fibras }}
								  								</li>
								  								<li>
								  									<b>Color de fibra:</b> <div style="width: 50px;height: 7px;background: {{ $t_c->color_fibras }};display:inline-block;"></div>
								  								</li>
								  								<li>
								  									<b>Descripcion:</b> {{ $t_c->descripcion }}
								  								</li>
								  							</ul>
								  						</div>
								  					</div>
								  				</div>
								  				<div class="modal-footer">
								  					<button data-dismiss="modal" type="button" class="btn btn-xs btn-danger">
								  						Cerrar
								  					</button>
								  				</div>
								  			</div>
								  		</div>
								  	</div>
								  	<div class="modal fade" id="delete_tc_{{ $t_c->codigo }}">
								  		<div class="modal-dialog modal-md">
								  			<div class="modal-content">
								  				<div class="modal-header">Eliminar plantilla {{ $t_c->codigo }}</div>
								  				<div class="modal-body">
								  					<div class="row">
								  						<div class="col-lg-12">
									  						<h4>
									  							Seguro de eliminar esta plantilla de cable?
									  						</h4>
									  						<div class="btn-group">
									  							<a href="{{ url('/admin/cable-templates/delete/'.$t_c->id) }}" class="btn btn-danger btn-xs">
									  								Si
									  							</a>
									  							<button data-dismiss="modal" type="button" class="btn btn-xs btn-info">
											  						No
											  					</button>
									  						</div>
								  						</div>
								  					</div>
								  				</div>
								  				<div class="modal-footer">
								  					<button data-dismiss="modal" type="button" class="btn btn-xs btn-danger">
								  						Cerrar
								  					</button>
								  				</div>
								  			</div>
								  		</div>
								  	</div>
								  	<div class="modal fade" id="edit_tc_{{ $t_c->codigo }}">
								  		<div class="modal-dialog modal-md">
								  			<form class="modal-content edit_tc_form" method="POST" action="{{ url('/admin/cable-templates/edit/'.$t_c->id) }}">
								  				{{csrf_field()}}
								  				<div class="modal-header">Editar plantilla de cable</div>

								  				<div class="modal-body">
								  					<div class="row">
								  						<div class="col-sm-4">
								  							<div class="form-group">
										  						<label>Codigo</label>
										  						<input type="text" class="form-control" name="codigo" value="{{ $t_c->codigo }}" required>
										  					</div>
								  						</div>
								  						<div class="col-sm-4">
								  							<div class="form-group">
										  						<label>N de fibras</label>
										  						<input type="number" min="1" class="form-control" name="numero_fibras" value="{{ $t_c->numero_fibras }}" required>
										  					</div>
								  						</div>
								  						<div class="col-sm-4">
								  							<div class="form-group">
										  						<label>Color de fibras</label>
										  						<input type="color" min="1" class="form-control" name="color_fibras" value="{{ $t_c->color_fibras }}" required>
										  					</div>
								  						</div>
								  						<div class="col-sm-12">
								  							<div class="form-group">
										  						<label>Descripcion</label>
										  						<textarea name="descripcion" id="description" cols="30" rows="5" class="form-control">{{ $t_c->descripcion }}</textarea>
										  					</div>
								  						</div>
								  					</div>
								  				</div>

								  				<div class="modal-footer">
								  					<button type="submit" class="btn btn-xs btn-success">Aceptar</button>
								  					<button data-dismiss="modal" type="button" class="btn btn-xs btn-danger">Cancelar</button>
								  				</div>

								  			</form>
								  		</div>
								  	</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="3" style="text-align:center">
									Sin resultados
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="modal fade" id="new_tc">
  		<div class="modal-dialog modal-md">
  			<form class="modal-content" id="new_tc_form" method="POST" action="{{ url('/admin/cable-templates/save') }}">
  				{{csrf_field()}}
  				<div class="modal-header">Nueva plantilla de cable</div>

  				<div class="modal-body">
  					<div class="row">
  						<div class="col-sm-4">
  							<div class="form-group">
		  						<label>Codigo</label>
		  						<input type="text" class="form-control" name="codigo" required>
		  					</div>
  						</div>
  						<div class="col-sm-4">
  							<div class="form-group">
		  						<label>N de fibras</label>
		  						<input type="number" min="1" class="form-control" name="numero_fibras" required>
		  					</div>
  						</div>
  						<div class="col-sm-4">
  							<div class="form-group">
		  						<label>Color de fibras</label>
		  						<input type="color" min="1" class="form-control" name="color_fibras" required>
		  					</div>
  						</div>
  						<div class="col-sm-12">
  							<div class="form-group">
		  						<label>Descripcion</label>
		  						<textarea name="descripcion" id="description" cols="30" rows="5" class="form-control"></textarea>
		  					</div>
  						</div>
  					</div>
  				</div>

  				<div class="modal-footer">
  					<button type="submit" class="btn btn-xs btn-success">Aceptar</button>
  					<button data-dismiss="modal" type="button" class="btn btn-xs btn-danger">Cancelar</button>
  				</div>

  			</form>
  		</div>
  	</div>
  	@section('scripts')
  		<script>
  			$(document).on('submit' , '#new_tc_form' , function(e){
  				e.preventDefault();
  				var form = $(this);

  				$.ajax({
  					url: form.attr('action'),
  					type: form.attr('method'),
  					data: form.serialize(),
  				})
  				.done(function(data) {
  					console.log(data);
  					if(data.success){
  						alert('Plantilla agregada exitosamente');
  						window.location.reload();
  					}
  				})
  				.fail(function() {
  					console.log("error");
  				})
  				.always(function() {
  					console.log("complete");
  				});
  			});	

  			$(document).on('submit' , '.edit_tc_form' , function(e){
  				e.preventDefault();
  				var form = $(this);

  				$.ajax({
  					url: form.attr('action'),
  					type: form.attr('method'),
  					data: form.serialize(),
  				})
  				.done(function(data) {
  					console.log(data);
  					if(data.success){
  						alert('Plantilla editada exitosamente');
  						window.location.reload();
  					}
  				})
  				.fail(function() {
  					console.log("error");
  				})
  				.always(function() {
  					console.log("complete");
  				});
  			});	
  		</script>
  	@endsection
@stop