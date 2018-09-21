@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/materials') }}">Material</a> :
@endsection
@section("contentheader_description", $material->$view_col)
@section("section", "Materials")
@section("section_url", url(config('laraadmin.adminRoute') . '/materials'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Materials Edit : ".$material->$view_col)

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
				{!! Form::model($material, ['route' => ['materials.update', $material->id ], 'method'=>'PUT', 'id' => 'material-edit-form']) !!}
					@la_form($module)

					{{--
					@la_input($module, 'material')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/materials') }}">Cancel</a></button>
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
	$("#material-edit-form").validate({

	});
});
</script>
@endpush
