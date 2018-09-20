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

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($ponto_coleta, ['route' => [config('laraadmin.adminRoute') . '.ponto_coletas.update', $ponto_coleta->id ], 'method'=>'PUT', 'id' => 'ponto_coleta-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'empresa')
					@la_input($module, 'categoria_empresa')
					@la_input($module, 'responsavel')
					@la_input($module, 'telefone')
					@la_input($module, 'material')
					@la_input($module, 'cnpj')
					@la_input($module, 'endereco')
					@la_input($module, 'cidade')
					@la_input($module, 'estado')
					@la_input($module, 'latitude')
					@la_input($module, 'longitude')
					@la_input($module, 'status')
					--}}
                    <br>
					<div class="form-group">
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
@endpush
