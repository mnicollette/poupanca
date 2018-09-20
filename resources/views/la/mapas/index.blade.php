@extends("la.layouts.app")

@section("contentheader_title", "Mapa")
@section("contentheader_description", "Pontos de Coleta")
@section("section", "Mapa")
@section("sub_section", "")
@section("htmlheader_title", "")

@section("headerElems")
@la_access("Mapas", "create")
	<!--<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Mapa</button>-->
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
		<div class="form-group col-xs-12" style="height:500px" id="map-canvas">
			<?php $locations=array();
			foreach( $pontos as $ponto ){
				$locations[] = array('name'=>$ponto->empresa,'lat'=>$ponto->latitude,'lng'=>$ponto->longitude);
			}
			$markers = json_encode($locations);
			?>

		</div>
	</div>
</div>
<?php print_r($pontos[0]->latitude); ?>
@endsection

@push('styles')

@endpush

@push('scripts')

<script type="text/javascript">
<?php
        echo "var markers=".$markers."\n";

    ?>
function initAutocomplete() {
				var myLatLng = {lat: -23.55, lng: -46.63};

        var map = new google.maps.Map(document.getElementById('map-canvas'), {
          center: myLatLng,
          zoom: 12,
          mapTypeId: 'roadmap'
        });

				var infowindow = new google.maps.InfoWindow(), marker, lat, lng;
				var json=jQuery.parseJSON(JSON.stringify(markers ));

        for(var o in json){

            lat = json[o].lat;
            lng=json[o].lng;
            name=json[o].name;

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat,lng),
                name:name,
                map: map
            });
            google.maps.event.addListener( marker, 'click', function(e){
                infowindow.setContent( this.name );
                infowindow.open( map, this );
            }.bind( marker ) );
        }

      }


</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUU4xJcdgKQVDHAiYOM0mxBDU8EOMJE-Y&libraries=places&callback=initAutocomplete" async defer></script>

@endpush
