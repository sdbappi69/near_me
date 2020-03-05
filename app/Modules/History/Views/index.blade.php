@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content">

    	<div class="row animated bounceInDown">
	        <div class="col-md-12">
	    		<div class="box box-info">
		            <div class="box-header with-border">
		              <h3 class="box-title">Filter</h3>
		            </div>
		            <!-- /.box-header -->
		            <!-- form start -->
		            {!! Form::open(array('method' => 'get')) !!}

		              	<div class="box-body">
		            		<div class="col-md-4">
		            			{{ Form::label('radius', 'Enter Radius') }}
		            			<?php if (!isset($_GET['radius'])) { $_GET['radius'] = null; } ?>
		            			<input value="{{ $_GET['radius'] }}" class="form-control input-lg" name="radius" type="number" placeholder="Enter Radius">
		            		</div>

					        <div class="col-md-4">
					        	{{ Form::label('type_id', 'Select Type') }}
					        	<?php if(!isset($_GET['type_id'])){$_GET['type_id'] = null;} ?>
					            {!! Form::select('type_id', ['' => 'Select Type']+$types, $_GET['type_id'], ['class' => 'form-control input-lg select2','id' => 'type_id']) !!}
					        </div>

		            		<div class="col-md-4">
		            			{{ Form::label('keyword', 'Enter Keyword') }}
		            			<?php if (!isset($_GET['keyword'])) { $_GET['keyword'] = null; } ?>
		            			<input value="{{ str_replace('+', ' ', $_GET['keyword']) }}" class="form-control input-lg" name="keyword" type="text" placeholder="Enter Keyword">
		            		</div>

		            		<div class="col-md-4">
		            			<label class="control-label">From</label>
		            			<?php if (!isset($_GET['start_date'])) { $_GET['start_date'] = null; } ?>
		            			<div class="input-group input-medium date date-picker input-full" data-date-format="yyyy-mm-dd" >
		                            <span class="input-group-btn">
		                                <button class="btn default" type="button">
		                                    <i class="fa fa-calendar"></i>
		                                </button>
		                            </span>
		                            {!! Form::text('start_date',$_GET['start_date'], ['class' => 'form-control datepicker input-lg','placeholder' => 'YYYY-MM-DD' ,'readonly' => 'true']) !!}
		                        </div>
		            		</div>
		            		<div class="col-md-4">
		            			<label class="control-label">To</label>
		            			<?php if (!isset($_GET['end_date'])) { $_GET['end_date'] = null; } ?>
		            			<div class="input-group input-medium date date-picker input-full" data-date-format="yyyy-mm-dd" >
		                            <span class="input-group-btn">
		                                <button class="btn default" type="button">
		                                    <i class="fa fa-calendar"></i>
		                                </button>
		                            </span>
		                            {!! Form::text('end_date',$_GET['end_date'], ['class' => 'form-control datepicker input-lg','placeholder' => 'YYYY-MM-DD' ,'readonly' => 'true']) !!}
		                        </div>
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
	        <div class="col-md-12">
	          <div class="box box-success">
	            <div class="box-header">
		            <h3 class="box-title">Search Histories</h3>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body table-responsive">
	              	<table class="table table-striped">

		                <tr>
		                	<th>Detail</th>
		                  	<th>Radius</th>
		                  	<th>Type</th>
		                  	<th>Keyword</th>
		                  	<th>Created at</th>
		                  	<th>Created by</th>
		                </tr>

		                @if(count($histories) > 0)
		                	@foreach($histories AS $history)
		                		<tr>
		                			<td>
		                				<a href="{{ url('/') }}/panel/history/{{ $history->id }}" class="btn btn-success">
		                					Detail
		                				</a>
		                			</td>
				                  	<td>{{ $history->radius }}</td>
				                  	<td>{{ $history->type->title }}</td>
				                  	<td>{{ $history->keyword }}</td>
				                  	<td>{{ $history->created_at }}</td>
				                  	<td>{{ $history->user->name }}</td>
				                </tr>
		                	@endforeach
		                @endIf

	              	</table>

	              	<div class="pagination pull-right">
                        {{ $histories->appends($_REQUEST)->render() }}
                    </div>

	            </div>
	            <!-- /.box-body -->
	          </div>
	          <!-- /.box -->
	        </div>
	    </div>

    </section>

    <script type="text/javascript">

	    $(document).ready(function () {
		    // page_select(menu_class, sub_menu_class, title, sub_title)
        	page_select('history', 'history', 'History', 'View');
		});

    </script>

@endsection