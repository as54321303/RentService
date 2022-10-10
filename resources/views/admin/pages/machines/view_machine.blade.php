@extends('admin.layouts.master')

@section('content')

  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>View Machine</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">View Machine</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	@if (session('success'))
	<div class="card-body">
	<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5>{{ Session::get('success') }}</h5>
	<?php Session::forget('success');?>
	</div>
    </div>
	@endif
	
	
	
	 <section class="content">

		
            <div class="card">
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <div class="row">
                    <div class="col-sm-6">

                        Model:

                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>




              </div>
            </div>
		
          {{-- </div>
        </div>
      </div> --}}
    </section>
   </div>

  @endsection

