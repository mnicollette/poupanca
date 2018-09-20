@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/upload_pontos_coletas') }}">Upload Pontos Coleta</a> :
@endsection
@section("contentheader_description", $upload_pontos_coleta->$view_col)
@section("section", "Upload Pontos Coletas")
@section("section_url", url(config('laraadmin.adminRoute') . '/upload_pontos_coletas'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Upload Pontos Coletas Edit : ".$upload_pontos_coleta->$view_col)

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
				{!! Form::model($upload_pontos_coleta, ['route' => [config('laraadmin.adminRoute') . '.upload_pontos_coletas.update', $upload_pontos_coleta->id ], 'method'=>'PUT', 'id' => 'upload_pontos_coleta-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'file')
					@la_input($module, 'modulo')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/upload_pontos_coletas') }}">Cancel</a></button>
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
	$("#upload_pontos_coleta-edit-form").validate({
		
	});
});
</script>
@endpush
