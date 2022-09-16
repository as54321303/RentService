@extends('user.layouts.master')

@section('title','My Orders')


@section('content')


<div class="container mt-5">

    <h1 class="mt-5">My Orders</h1>

	<div class="cart mb-5 mt-5">

        <div class="card mb-5">
        
            <div class="card-body">

                <table id="example" class="table table-bordered table-striped">

                    <thead>
                        <h1 class="mt-3 mb-3">My Orders</h1>
                        <tr>
                            <td>Instrument Name</td>
                            <td>Image</td>
                            <td>Price</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td><img src="{{$item->image}}" style="height:80px;width:80px;"></td>
                            <td>${{$item->price}}</td>
                            <td>{{$item->status}}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
 
            </div>
        </div>


	
	</div>

</div>


    
@endsection