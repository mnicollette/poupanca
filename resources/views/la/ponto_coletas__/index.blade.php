@extends("la.layouts.app")

@section("contentheader_title", "Ponto Coletas")
@section("contentheader_description", "Ponto Coletas listing")
@section("section", "Ponto Coletas")
@section("sub_section", "Listing")
@section("htmlheader_title", "Ponto Coletas Listing")

@section("headerElems")
@la_access("Ponto_Coletas", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Ponto Coleta</button>
@endla_access
@endsection

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			@foreach( $listing_cols as $col )
			<th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
			@endforeach
			@if($show_actions)
			<th>Actions</th>
			@endif
		</tr>
		</thead>
		<tbody>

		</tbody>
		</table>
	</div>
</div>
<style>
.loading{
  position: absolute;
    width: 94%;
    height: 105%;
    background: rgba(255,255,255, .7);
    padding: 27%;
}
.pac-container {
    background-color: #FFF;
    z-index: 2001;
    position: fixed;
    display: inline-block;
    float: left;
}
.modal{
    z-index: 2000;
}
.modal-backdrop{
    z-index: 1000;
}
</style>
@la_access("Ponto_Coletas", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Ponto Coleta</h4>
			</div>
			{!! Form::open(['action' => 'LA\Ponto_ColetasController@store', 'id' => 'ponto_coleta-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
					<div class="form-group col-xs-12">
						<label for="empresa">Empresa*:</label>
						<input class="form-control" placeholder="Enter Empresa" data-rule-maxlength="256" required="1" name="empresa" type="text" value="" aria-required="true">
					</div>
					<div class="form-group col-xs-12">
						<label for="responsavel">Responsável:</label>
						<input class="form-control" placeholder="Enter Empresa" data-rule-maxlength="100" name="responsavel" type="text" value="">
					</div>
					<div class="form-group col-xs-12">
						<label for="telefone">Telefone:</label>
						<input class="form-control" placeholder="Enter Empresa" data-rule-maxlength="80" name="telefone" type="text" value="">
					</div>
					<div class="form-group col-xs-6">
					    <label for="categoria_empresa">Categoria da empresa :</label><br>
							@foreach($categorias as $categoria)
							<input class="" name="categoria_empresa[]" type="checkbox" value="{{$categoria->id}}">{{$categoria->categoria}}<br>
							@endforeach
					</div>
					<div class="form-group col-xs-6">
					    <label for="material">Material trabalho :</label><br>
							@foreach($materiais as $material)
							<input class="" name="material[]" type="checkbox" value="{{$material->id}}">{{$material->material}}<br>
							@endforeach
					</div>
					<div class="form-group col-xs-12">
						<label for="endereco">Endereço:</label>
						<input type="text" name="endereco" class="controls col-xs-12" id="searchmap">

					</div>
					<div class="form-group col-xs-12" style="height:300px" id="map-canvas">

					</div>
					<div class="form-group col-xs-6">
						<label for="latitude">Latitude:</label>
						<input class="form-control" placeholder="Enter Latitude" id="latitude" name="latitude" type="text" value=""  readonly="readonly">
					</div>
					<div class="form-group col-xs-6">
						<label for="longitude">Longitude:</label>
						<input class="form-control" placeholder="Enter Longitude" id="longitude" name="longitude" type="text" value=""  readonly="readonly">
					</div>
					<div class="form-group col-xs-4">
						<label for="cnpj">CNPJ*:</label>
						<input class="form-control" placeholder="Enter CNPJ" data-rule-maxlength="20" required="1" name="cnpj" type="text" value="" aria-required="true">
					</div>
					<div class="form-group col-xs-4">
						<label for="cidade">Cidade:</label>
						<input class="form-control" placeholder="Enter Cidade" data-rule-maxlength="80" name="cidade" type="text" value="">
					</div>
					<div class="form-group col-xs-4">
						<label for="estado">Estado:</label>
						<input class="form-control" placeholder="Enter Estado" data-rule-maxlength="2" name="estado" type="text" value="">
					</div>
					<div class="form-group col-xs-12">

						<input class="form-control" placeholder="Enter Status" required="1" name="status" type="hidden" value="1" aria-required="true">
					</div>

					<div class="loading">
						<img src="../la-assets/img/load.gif" width="200" alt="">
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endla_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')

<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
	$("#example1").DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/ponto_coleta_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#ponto_coleta-add-form").validate({

	});
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
			$(".loading").hide();
		});
			function latlgt(){
				$(".loading").show();
				var endereco = $("#endereco").val();
			$.ajax({
            type: 'GET',
						data: { 'endereco': endereco },
            url : "{{ url(config('laraadmin.adminRoute') . '/ponto_coleta_latlgt') }}",
						datatype: 'JSON',
            success : function (data) {
							var resultado = JSON.parse(data);
							$("#latitude").val(resultado['results'][0]['geometry']['location']['lat']);
							$("#longitude").val(resultado['results'][0]['geometry']['location']['lng']);
							$(".loading").hide();
            }
        });
			}
</script>
<script type="text/javascript">

function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
          center: {lat: -23.5504, lng: -46.6339},
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('searchmap');
        var searchBox = new google.maps.places.SearchBox(input);
        //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();

          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location,
							draggable: true
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }

											var lat = markers[0].getPosition().lat();
											var lng = markers[0].getPosition().lng();

											$('#latitude').val(lat);
											$('#longitude').val(lng);
          });
          map.fitBounds(bounds);

					markers[0].addListener('position_changed',function(){
						var lat = markers[0].getPosition().lat();
						var lng = markers[0].getPosition().lng();

						$('#latitude').val(lat);
						$('#longitude').val(lng);
					});

        });

      }


</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUU4xJcdgKQVDHAiYOM0mxBDU8EOMJE-Y&libraries=places&callback=initAutocomplete" async defer></script>
@endpush
