@extends('user.layouts.master')
@section('title','Cart')
    
@section('style')

<style>

@import url('https://fonts.googleapis.com/css2?family=Comfortaa&display=swap');

*{

	font-family: 'Comfortaa', cursive;

	margin: 0;

	padding: 0;

	box-sizing: border-box;

}

.container{

	max-width: 1200px;

	margin: 0 auto;

}

.container > h1{

	padding: 20px 0;

}

.cart{

	display: flex;

}

.products{

	flex: 0.75;

}

.product{

	display: flex;

	width: 100%;

	height: 200px;

	overflow: hidden;

	border: 1px solid silver;

	margin-bottom: 20px;

}

.product:hover{

	border: none;

	box-shadow: 2px 2px 4px rgba(0,0,0,0.2);

	transform: scale(1.01);

}

.product > img{

	width: 300px;

	height: 200px;

	object-fit: cover;

}

.product > img:hover{

	transform: scale(1.04);

}

.product-info{

	padding: 5px;

	width: 100%;

	position: relative;

}

.product-name, .product-price, .product-offer{

	margin-bottom: 20px;

}

.product-remove{

	position: absolute;

	bottom: 20px;

	right: 20px;

	padding: 10px 25px;

	background-color: green;

	color: white;

	cursor: pointer;

	border-radius: 5px;

}

.product-remove:hover{

	background-color: white;

	color: green;

	font-weight: 600;

	border: 1px solid green;

}

.product-quantity > input{

	width: 40px;

	padding: 5px;

	text-align: center;
    
}

.fa{

	margin-right: 5px;

}

.cart-total{

	flex: 0.25;

	margin-left: 20px;

	padding: 20px;

	height: 240px;

	border: 1px solid silver;

	border-radius: 5px;

}

.cart-total p{

	display: flex;

	justify-content: space-between;

	margin-bottom: 30px;

	font-size: 20px;

}

.cart-total a{

	display: block;

	text-align: center;

	height: 40px;

	line-height: 40px;

	background-color: tomato;

	color: white;

	text-decoration: none;

}

.cart-total a:hover{

	background-color: red;

}

@media screen and (max-width: 700px){

	.remove{

		display: none;

	}

	.product{

		height: 150px;

	}

	.product > img{

		height: 150px;

		width: 200px;

	}

	.product-name, .product-price, .product-offer{

		margin-bottom: 10px;

	}

}

@media screen and (max-width: 900px){

	.cart{

		flex-direction: column;

	}

	.cart-total{

		margin-left: 0;

		margin-bottom: 20px;

	}

}

@media screen and (max-width: 1220px){

	.container{

		max-width: 95%;

	}

}







     

   </style>

@endsection

@section('content')


<div class="container">

    <h1 class="mt-5">Shopping Cart</h1>

	<div class="cart mb-5 mt-5">


		<div class="products">


            @if(session('cart'))

            @foreach(session('cart') as $id => $details)

                

			<div class="product">

				<img src="{{$details['image']}}">

				<div class="product-info ml-3">

					<h3 class="product-name">  {{$details['name']}}</h3>

					<h4 class="product-price"> 	$ {{$details['price']}}</h4>

					{{-- <h5 style="width: 70%;height:100%;" >{{$details['description']}}</h5> --}}

					<p class="product-remove">

						<input type="hidden" value="" class="product_id">

			<a href="{{url('remove-item',$id)}}"><i class="fa fa-trash"></i>
			
				<span>Remove</span>


			</a>

					</p>

				</div>

			</div>

            @endforeach

            @else

		


		<h3>	No Items Selected...</h3>

		<div></div>
		<a href="{{url('home')}}"> <button class="btn btn-primary">Shop here...</button></a>
			</div>	


	@endif

        

		</div>


		<div class="cart-total">

			@php
				$price=0;
				$instrument_id='';
				$distinct_price='';
			@endphp
   @if(session('cart'))
			<input type="hidden" @foreach (session('cart') as $item)
				{{$price=$price+$item['price']}}
				{{$instrument_id=$instrument_id.$item['id'].','}}
				{{$distinct_price=$distinct_price.$item['price'].','}}
			@endforeach>
			@endif

			<p>

					<span>Amount Payable</span>
				
				<span class="total_price">${{$price}}</span>

			</p>

			<p>

				<span>Number of Items</span>

				<span>@if(session('cart')){{count(session('cart'))}}@endif</span>

			</p>


                 <form action="{{url('stripe')}}" method="GET">
					@csrf
					<input type="hidden" name="price" value="{{$price}}">
					<input type="hidden" name="instrument_id" value="{{$instrument_id}}">
					<input type="hidden" name="distinct_price" value="{{$distinct_price}}">
					<button type="submit" class="btn btn-danger">Proceed to Checkout</button>

				 </form>


		</div>

	
	</div>

</div>

    

@endsection