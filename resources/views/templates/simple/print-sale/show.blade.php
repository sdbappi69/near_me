@extends('templates.simple.layouts.app')

@section('content')

	<div class="container inner">
      <div class="divide20"></div>
      <div class="row">
        <div class="col-sm-8">
          <figure><img src="{{ url('uploads/photos/full').'/'.$photo->image }}" alt="{{ $photo->name }}"></figure>
        </div>
        <!-- /column -->
        <div class="col-sm-4">
          
           
          	<h2>{{ $photo->name }}</h2>
          	@if($photo->price != null) <p>Price: {{ $photo->price or '' }}</p> @endIf
			@if($photo->description != null) <p>{{ $photo->description or '' }}</p> @endIf
          	<div class="divide25"></div>

          	{{ Form::open(array('url' => 'order-print-sales')) }}

				{{ Form::hidden('id', $photo->id) }}

				<div class="form-group">
        			{{ Form::text('name', Input::old('name'), array('class' => 'form-control input-lg', 'placeholder' => 'Name*', 'required' => 'required', 'id' => 'name')) }}
        		</div>
        		<div class="form-group">
        			{{ Form::email('email', Input::old('email'), array('class' => 'form-control input-lg', 'placeholder' => 'Email*', 'required' => 'required', 'id' => 'email')) }}
        		</div>
        		<div class="form-group">
        			{{ Form::text('contact', Input::old('contact'), array('class' => 'form-control input-lg', 'placeholder' => 'Contact*', 'required' => 'required')) }}
        		</div>
        		<div class="form-group">
        			{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control input-lg', 'placeholder' => 'Remarks', 'rows' => '7')) }}
        		</div>
        		<div class="form-group">
        			<input style="margin-top: 10px;" type="submit" class="btn btn-info"  value="Send Request">
        		</div>

			{!! Form::close() !!}
          
          <a href="{{ url('print-sales') }}" class="btn btn-orange">Go Back</a>

          <div id="shareIcons"></div>
          
        </div>
        <!-- /column --> 
        
      </div>
      <!-- /.row -->
      <div class="clearfix"></div>
    </div>
    <!--/.container --> 

	<script type="text/javascript">

		$(document).ready(function () {

			page_select('print-sales', 'print-sales');

			$("#name").focus();

		});

	</script>

@endsection