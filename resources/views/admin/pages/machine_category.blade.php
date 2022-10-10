@extends('admin.layouts.master')

@section('content')

  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Machine Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Machine Category</li>
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
                {{-- <h3 class="card-title"><a href="{{url('add-product')}}"><button type="button" class="btn btn-block bg-gradient-primary">Add Instrument</button></a></h3> --}}
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th class="text-center">S.No</th>
                    <th class="text-center">Category</th>
                    <th class="text-center">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($machine_category as $key=>$category)                   
                    <tr>
                      <td class="text-center">{{$key+1}}</td>
                      <td class="text-center">{{$category->category}}</td>
                      <td class="text-center">
                        <button class="btn btn-primary">Edit</button>
                        <button class="btn btn-danger">Delete</button>
                      </td>
                   </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                        <th class="text-center">S.No</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Action</th>
                      </tr>
                  </tfoot>
                </table>
              </div>
            </div>
		
          {{-- </div>
        </div>
      </div> --}}
    </section>
   </div>

  @endsection

