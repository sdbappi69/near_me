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
		            			<?php if (!isset($_GET['display_name'])) { $_GET['display_name'] = null; } ?>
		            			<input value="{{ $_GET['display_name'] }}" class="form-control input-lg" name="display_name" type="text" placeholder="Display Name">
		            		</div>
		            		<div class="col-xs-3">
		            			<?php if (!isset($_GET['name'])) { $_GET['name'] = null; } ?>
		            			<input value="{{ $_GET['name'] }}" class="form-control input-lg" name="name" type="text" placeholder="Name">
		            		</div>
		            		<div class="col-xs-3">
		            			<?php if (!isset($_GET['description'])) { $_GET['description'] = null; } ?>
		            			<input value="{{ $_GET['description'] }}" class="form-control input-lg" name="description" type="text" placeholder="Description">
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
		            <h3 class="box-title">Roles</h3>

		            <div class="box-tools">
		                <a href="{{ url('roles/create') }}" class="btn btn-block btn-success">
		                	<i class="fa fa-plus"></i> Create new
		                </a>
	              	</div>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body table-responsiveusers">
	              	<table class="table table-striped">

		                <tr>
		                  	<th>Display Name</th>
		                  	<th>Name</th>
		                  	<th>Description</th>
		                  	<th>Actions</th>
		                </tr>

		                @if(count($roles) > 0)
		                	@foreach($roles AS $role)
		                		<tr>
				                  	<td>{{ $role->display_name }}</td>
				                  	<td>{{ $role->name }}</td>
				                  	<td>{{ $role->description }}</td>
				                  	<td>
				                  		<div class="btn-group">
					                      	{{ Form::open(array('url' => 'roles/'.$role->id)) }}
							                    {{ Form::hidden('_method', 'DELETE') }}
							                    <a href="{{ url('roles/'.$role->id) }}" class="btn btn-default"><i class="fa fa-eye"></i></a>
					                      		<a href="{{ url('roles/'.$role->id.'/edit') }}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
							                    <button type="submit" class="btn btn-default"><i class="fa fa-times"></i></button>
							                {{ Form::close() }}
					                    </div>
				                  	</td>
				                </tr>
		                	@endforeach
		                @endIf

	              	</table>

	              	<div class="pagination pull-right">
                        {{ $roles->appends($_REQUEST)->render() }}
                    </div>

	            </div>
	            <!-- /.box-body -->
	          </div>
	          <!-- /.box -->
	        </div>
	    </div>

    </section>

@endsection