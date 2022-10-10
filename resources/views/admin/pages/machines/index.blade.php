@extends('admin.layouts.master')

@section('content')

  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Machines</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Machines</li>
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
                <table id="example" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Image</th>
                    <th>Machine Category</th>
                    <th>Model</th> 
                    <th>Status  ( Approval ) </th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($machines as $key=>$machine)                   
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>
                        <img src="{{$machine->image}}" style="height:100px;width:100px;">
                    </td>
                      <td>{{$machine->category}}</td>
                      <td>{{$machine->model}}</td>
                      <td>
                       @if ($machine->isApproved==1)
                           Approved
                       @else
                           Pending
                       @endif
                       </td>
                      <td>
                       <a href="{{url('view-machine/'.$machine->id)}}"> <button class="btn btn-primary"><i class="fa fa-eye"></i></button></a>
                       </a> <button class="btn btn-primary"><i class="fa fa-edit"></i></button>
                      </td>
                   </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                        <th>S.No</th>
                        <th>Image</th>
                        <th>Machine Category</th>
                        <th>Model</th>
                        <th>Status ( Approval )</th>
                        <th>Action</th>
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

