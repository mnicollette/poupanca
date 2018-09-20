@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/ponto_coletas') }}">Ponto Coleta</a> :
@endsection
@section("contentheader_description", $ponto_coleta->$view_col)
@section("section", "Ponto Coletas")
@section("section_url", url(config('laraadmin.adminRoute') . '/ponto_coletas'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Ponto Coletas Edit : ".$ponto_coleta->$view_col)

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
<style>
.loading{
  position: absolute;
    width: 94%;
    height: 105%;
    background: rgba(255,255,255, .7);
    padding: 27%;
}
</style>
<div class="box">
	<div class="box-header">

	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($ponto_coleta, ['route' => [config('laraadmin.adminRoute') . '.ponto_coletas.update', $ponto_coleta->id ], 'method'=>'PUT', 'id' => 'ponto_coleta-edit-form']) !!}

					<div class="modal-body">
						<div class="box-body">
							<div class="form-group col-xs-12">
								<label for="empresa">Empresa*:</label>
								<input class="form-control" placeholder="Enter Empresa" data-rule-maxlength="256" required="1" id="empresa" name="empresa" type="text" value="{{$ponto_coleta->empresa}}" aria-required="true">
							</div>
							<div class="form-group col-xs-6">
							    <label for="categoria_empresa">Categoria da empresa :</label><br>
									<?php
									$pc = str_replace(array("[","]",'"'),"",$ponto_coleta->categoria_empresa);
									$pc = explode(",",$pc);
									  ?>
									@foreach($categorias as $categoria)
									<input class="" name="categoria_empresa[]" type="checkbox" value="{{$categoria->id}}" {{ (is_array($pc) && in_array($categoria->id,$pc)) ? 'checked' : '' }} />{{$categoria->categoria}}<br>
									@endforeach
							</div>
							<div class="form-group col-xs-6">
							    <label for="material">Material trabalho :</label><br>
									<?php
									$mt = str_replace(array("[","]",'"'),"",$ponto_coleta->material);
									$mt = explode(",",$mt);
									  ?>
									@foreach($materiais as $material)
									<input class="" name="material[]" type="checkbox" value="{{$material->id}}" {{ (is_array($mt) && in_array($material->id,$mt)) ? 'checked' : '' }}/>{{$material->material}}<br>
									@endforeach
							</div>
							<div class="form-group col-xs-12">
								<label for="endereco">Endereço:</label>
								<input type="text" name="endereco" value="{{$ponto_coleta->endereco}}" class="controls col-xs-12" id="searchmap">

							</div>
							<div class="form-group col-xs-12" style="height:300px" id="map-canvas">

							</div>
							<div class="form-group col-xs-6">
								<label for="latitude">Latitude:</label>
								<input class="form-control" placeholder="Enter Latitude" id="latitude" name="latitude" type="text" value="{{$ponto_coleta->latitude}}"  readonly="readonly">
							</div>
							<div class="form-group col-xs-6">
								<label for="longitude">Longitude:</label>
								<input class="form-control" placeholder="Enter Longitude" id="longitude" name="longitude" type="text" value="{{$ponto_coleta->longitude}}"  readonly="readonly">
							</div>
							<div class="form-group col-xs-4">
								<label for="cnpj">CNPJ*:</label>
								<input class="form-control" placeholder="Enter CNPJ" data-rule-maxlength="20" required="1" name="cnpj" type="text" value="{{$ponto_coleta->cnpj}}" aria-required="true">
							</div>
							<div class="form-group col-xs-4">
								<label for="cidade">Cidade:</label>
								<input class="form-control" placeholder="Enter Cidade" data-rule-maxlength="80" name="cidade" type="text" value="{{$ponto_coleta->cidade}}">
							</div>
							<div class="form-group col-xs-4">
								<label for="estado col-xs-6">Estado:</label>
								<input class="form-control" placeholder="Enter Estado" data-rule-maxlength="2" name="estado" type="text" value="{{$ponto_coleta->estado}}">
							</div>
							<div class="form-group col-xs-12">

								<input class="form-control" placeholder="Enter Status" required="1" name="status" type="hidden" value="1" aria-required="true">
							</div>

							<div class="loading">
								<img src="../../../la-assets/img/load.gif" width="200" alt="">
							</div>

						</div>
					</div>
                    <br>
					<div class="form-group col-xs-12">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/ponto_coletas') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#ponto_coleta-edit-form").validate({

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
				var myLatLng = {lat: parseFloat($("#latitude").val()), lng: parseFloat($("#longitude").val())};
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
          center: myLatLng,
          zoom: 13,
          mapTypeId: 'roadmap'
        });

				var marker = new google.maps.Marker({
			    position: myLatLng,
			    map: map,
			    title: $("#empresa").val()
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
