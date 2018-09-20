@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/mapas') }}">Mapa</a> :
@endsection
@section("contentheader_description", $mapa->$view_col)
@section("section", "Mapas")
@section("section_url", url(config('laraadmin.adminRoute') . '/mapas'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Mapas Edit : ".$mapa->$view_col)

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

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($mapa, ['route' => [config('laraadmin.adminRoute') . '.mapas.update', $mapa->id ], 'method'=>'PUT', 'id' => 'mapa-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'location')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/mapas') }}">Cancel</a></button>
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
	$("#mapa-edit-form").validate({
		
	});
});
</script>
@endpush
