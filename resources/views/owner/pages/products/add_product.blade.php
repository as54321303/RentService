@extends('owner.layouts.master')
@section('content')
  <div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Machine</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Add Machine</li>
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



    @if (session('failed'))
    <div class="card-body">
       <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <h5>{{ Session::get('failed') }}</h5>
                <?php Session::forget('failed');?>
       </div>
    </div>
    @endif


    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- jquery validation -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Add Machine</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{url('post-add-product')}}" role="form" id="quickForm" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">


                    <div class="form-group">
                        <label for="p_name">Name</label>
                        <input type="text" name="p_name" id="p_name" class="form-control"  placeholder="product name...">
                      </div>

                 
	     			<div class="form-group">
                    <label for="exampleInputFile">Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="exampleInputFile" required>
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                          <textarea name="p_description" id="" cols="100" rows="5"></textarea>
                      </div>



                    <div class="form-group">
                        <label for="p_price">Price (In USD)</label>
                        <input type="text" name="p_price" id="p_price" class="form-control"  placeholder="product price...">
                      </div>

                   </div>
                  
          
                  <!-- /.card-footer -->
                  <div class="card-footer">
                    <button type="submit" id="submit" class="btn btn-primary">Add</button>
                  </div>
                  
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->

  </div>

  @endsection

    @section('script')


    

                <script>

                $(document).ready(function(){

                  $('.select2').select2()


                //Initialize Select2 Elements
                  $('#user').select2({
                    theme: 'bootstrap4'
                  });


                });

                </script>

    @endsection


  