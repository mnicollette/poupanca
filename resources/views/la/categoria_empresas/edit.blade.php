@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/categoria_empresas') }}">Categoria Empresa</a> :
@endsection
@section("contentheader_description", $categoria_empresa->$view_col)
@section("section", "Categoria Empresas")
@section("section_url", url(config('laraadmin.adminRoute') . '/categoria_empresas'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Categoria Empresas Edit : ".$categoria_empresa->$view_col)

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
				{!! Form::model($categoria_empresa, ['route' => [config('laraadmin.adminRoute') . '.categoria_empresas.update', $categoria_empresa->id ], 'method'=>'PUT', 'id' => 'categoria_empresa-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'categoria')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/categoria_empresas') }}">Cancel</a></button>
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
	$("#categoria_empresa-edit-form").validate({
		
	});
});
</script>
@endpush
