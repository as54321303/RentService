@extends('user.layouts.master')

@section('content')

      <section class="w3l-passion-sec2 py-5">
        <div class="container py-md-5 py-3">
            <div class="container">
                <div class="row w3l-passion-mid-grids">
                    <div class="col-lg-6 passion-grid-item-info pe-lg-5 mb-lg-0 mb-5">
                        <div class="title-content-two">
                            <h6 class="title-subw3hny mb-1 text-left mt-5">Detail</h6>
                            <h3 class="title-w3l mb-4">{{$product_detail[0]->name}}</h3>
                        </div>
                        <p class="mt-3 pe-lg-5">{{$product_detail[0]->description}}</p>
                        <div class="w3banner-content-btns">
                            <a href="{{url('add-cart-session',$product_detail[0]->id)}}" class="btn btn-style btn-primary mt-lg-5 mt-4 me-2">Add to cart</a>
                            <a href="#" class="btn btn-style btn-outline-dark mt-lg-5 mt-4">$    {{$product_detail[0]->price}}</a>
                        </div>

                    </div>
                    <div class="col-lg-6 w3hny-passion-item">
                        <img src="{{$product_detail[0]->image}}" alt="" class="img-fluid radius-image" style="height:300px;width:300px;">
                    </div>
                </div>

            </div>
        </div>
    </section>
    
@endsection