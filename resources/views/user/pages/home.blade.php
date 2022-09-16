@extends('user.layouts.master')

@section('title','Home-Page | Rent Services Online')
    
@section('content')

<section class="w3l-services py-5" id="services">
    <div class="container py-lg-5 py-md-4 py-2">
        <div class="title-content mb-5 text-center">
            {{-- <h6 class="title-subw3hny mb-1">Services</h6> --}}
            <h3 class="title-w3l mb-4 mt-5">Rent Services</h3>
        </div>
        <div class="row about-cols">

            @foreach($products as $product)

            <div class="col-md-4">
                <div class="about-col">
                    <div class="img">
                        <img src="{{$product->image}}" alt="" class="img-fluid radius-image" style="height:;width:400px;">
                        <div class="icon"><i class="fas fa-pencil-ruler"></i></div>
                    </div>
                    <h4 class="title"><a href="#">{{$product->name}}</a></h4>
                    <p>
                        {{$product->description}}
                    </p>
                    <div class="text-center">
                   <a href="{{url('product-detail',$product->id)}}"><button class="btn btn-success">View Machine</button></a> 
                   {{-- <a href="{{url('add-cart',$product->id)}}"><button class="btn btn-success">Add to Cart</button></a>  --}}
                   <a href="{{url('add-cart-session',$product->id)}}"><button class="btn btn-success">Add to Cart</button></a> 
                </div>  
                </div>
            </div>

            @endforeach
            {{-- <div class="col-md-4">
                <div class="about-col">
                    <div class="img">
                        <img src="assets/images/g3.jpg" alt="" class="img-fluid radius-image">
                        <div class="icon"><i class="fas fa-tools"></i></div>
                    </div>
                    <h4 class="title"><a href="#">Renovation</a></h4>
                    <p>
                        Lorem ipsum viverra feugiat. Pellen tesque libero ut justo, ultrices in ligula. Semper at tempufddfel.
                    </p>
                </div>
            </div> --}}

            {{-- <div class="col-md-4">
                <div class="about-col">
                    <div class="img">
                        <img src="assets/images/g4.jpg" alt="" class="img-fluid radius-image">
                        <div class="icon"><i class="fas fa-paint-roller"></i></div>
                    </div>
                    <h4 class="title"><a href="#">Construction</a></h4>
                    <p>
                        Lorem ipsum viverra feugiat. Pellen tesque libero ut justo, ultrices in ligula. Semper at tempufddfel.
                    </p>
                </div>
            </div> --}}

        </div>
    </div>
</section>
    
@endsection