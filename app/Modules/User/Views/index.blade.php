@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content">

    	<div class="row animated bounceInDown">
	        <div class="col-xs-12">
	    		<div class="box box-info">
		            <div class="box-header with-border">
		              <h3 class="box-title">Filter</h3>
		            </div>
		            <!-- /.box-header -->
		            <!-- form start -->
		            {!! Form::open(array('method' => 'get')) !!}

		              	<div class="box-body">
		            		<div class="col-xs-3">
		            			<?php if (!isset($_GET['name'])) { $_GET['name'] = null; } ?>
		            			<input value="{{ $_GET['name'] }}" class="form-control input-lg" name="name" type="text" placeholder="Name">
		            		</div>
		            		<div class="col-xs-3">
		            			<?php if (!isset($_GET['email'])) { $_GET['email'] = null; } ?>
		            			<input value="{{ $_GET['email'] }}" class="form-control input-lg" name="email" type="email" placeholder="Email">
		            		</div>
		              	</div>
		              	<!-- /.box-body -->
		              	<div class="box-footer">
		                	<input type="reset" class="btn btn-default" value="Reset">
		                	<input type="submit" class="btn btn-info pull-right"  value="Search">
		              	</div>
		              	<!-- /.box-footer -->

		            {!! Form::close() !!}
		        </div>
	        </div>
	    </div>

    	<div class="row animated bounceInUp">
	        <div class="col-xs-12">
	          <div class="box box-success">
	            <div class="box-header">
		            <h3 class="box-title">Users</h3>

		            <div class="box-tools">
		                <a href="{{ url('users/create') }}" class="btn btn-block btn-success">
		                	<i class="fa fa-plus"></i> Create new
		                </a>
	              	</div>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body table-responsiveusers">
	              	<table class="table table-striped">

		                <tr>
		                  	<th>Image</th>
		                  	<th>Name</th>
		                  	<th>Email</th>
		                  	<th>Actions</th>
		                </tr>

		                @if(count($users) > 0)
		                	@foreach($users AS $user)
		                		<tr>
				                  	<td>
				                  		<div class="user-block">
						                    <img class="img-circle img-bordered-sm" src="{{ url('uploads/users').'/'.$user->image }}" alt="{{ $user->name }}">
						                </div>
				                  	</td>
				                  	<td>{{ $user->name }}</td>
				                  	<td>{{ $user->email }}</td>
				                  	<td>
				                  		<div class="btn-group">
					                      	{{ Form::open(array('url' => 'users/'.$user->id)) }}
							                    {{ Form::hidden('_method', 'DELETE') }}
							                    <a href="{{ url('users/'.$user->id) }}" class="btn btn-default"><i class="fa fa-eye"></i></a>
					                      		<a href="{{ url('users/'.$user->id.'/edit') }}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
							                    <button type="submit" class="btn btn-default"><i class="fa fa-times"></i></button>
							                {{ Form::close() }}
					                    </div>
				                  	</td>
				                </tr>
		                	@endforeach
		                @endIf

	              	</table>

	              	<div class="pagination pull-right">
                        {{ $users->appends($_REQUEST)->render() }}
                    </div>

	            </div>
	            <!-- /.box-body -->
	          </div>
	          <!-- /.box -->
	        </div>
	    </div>

    </section>

@endsection