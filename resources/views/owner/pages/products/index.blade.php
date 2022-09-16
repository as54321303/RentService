@extends('owner.layouts.master')

@section('content')

  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Machine</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('owner-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Machine</li>
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
                <h3 class="card-title"><a href="{{url('add-product')}}"><button type="button" class="btn btn-block bg-gradient-primary">Add Machine</button></a></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Machine Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Price($)</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($products as $key=>$product)                   
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$product->name}}</td>
                      <td><img src="{{$product->image}}" style="height: 80px;width:80px;"></td>
                      <td>{{$product->description}}</td>
                      <td>{{$product->price}}</td>
                      <td>
                        <button type="button" class="btn btn-primary" data-target="#editModal{{$product->id}}"  data-toggle="modal" ><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-danger" data-target="#deleteModal{{$product->id}}"  data-toggle="modal" ><i class="fa fa-trash"></i></button>
                      </td>
                   </tr>


                   <div class="modal fade" id="deleteModal{{$product->id}}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Alert</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>Are You Sure You Want To Delete This Item ?</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                          <a href="{{url('delete-product/'.$product->id)}}"><button type="button" class="btn btn-primary">Yes</button></a>
                        </div>
                      </div>
                    </div>
                  </div>	




                  <div class="modal fade" id="editModal{{$product->id}}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Update Meal</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="{{url('update-product')}}" role="form" method="post" enctype="multipart/form-data">
                            @csrf
                           <div class="card-body">

                            <input type="hidden" value="{{$product->id}}" name="id">
                         
                             <div class="form-group">
                               <label for="name">Machine Name</label>
                               <input type="text" name="name" value="{{$product->name}}" class="form-control" id="name" placeholder="Enter machine name...">
                             </div>

                             {{-- <div class="form-group">
                              <label for="image">Image</label>
                              <input type="file" name="image"  class="form-control" id="image" required>
                            </div> --}}


                             <div class="form-group">
                               <label for="description">Machine Description</label>
                               <input type="text" name="description" value="{{$product->description}}" class="form-control" id="description" placeholder="Machine description...">
                             </div>

                             <div class="form-group">
                               <label for="price">Price($)</label>
                               <input type="text" name="price" value="{{$product->price}}" class="form-control" id="price" placeholder="Machine price...">
                             </div>
                     
            
            
                            <button type="submit" id="submit" class="btn btn-primary mt-3">Update</button>
            
                           </div>
                         </form>
                         
                         
                        </div>
                      </div>
                    </div>
                  </div>	
                      



                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>S.No</th>
                      <th>Machine Name</th>
                      <th>Image</th>
                      <th>Description</th>
                      <th>Price($)</th>
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

