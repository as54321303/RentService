<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe;


class UserController extends Controller
{

    public function user()
    {
        $user_id=session('userId');

        return $user=User::where('id',$user_id)->pluck('name');
    }

    public function home()
    {
        $products=Product::orderBy('id','desc')->get();
        return view('user.pages.home',compact('products'));
    }


   public function user_register()
   {
    return view('user.auth.register');
   }

   public function post_user_register(Request $request)
   {

    $request->validate([

        'username'=>'required',
        'email'=>'required|email|unique:users,email',
        'password'=>'required|min:4|max:20'
    ]);

    User::create([

        'name'=>$request->username,
        'email'=>$request->email,
        'password'=>Hash::make($request->password)

    ]);

    $user_id=User::where('email',$request->email)->get();

    session()->put('userId',$user_id[0]->id);

    return redirect('home');


   }

   public function user_login()
   {
    return view('user.auth.login');
   }

   public function post_user_login(Request $request)
   {
    
       $request->validate([
        'email'=>'required|email',
        'password'=>'required'

       ]);

       $user=User::where('email',$request->email)->get()->count();
       if($user){

        $pass_check=User::where('email',$request->email)->get();

        if(Hash::check($request->password,$pass_check[0]->password)){

            session()->put('userId',$pass_check[0]->id);
            return redirect('home');


        }
        else{

            \Session::put('failed','Password is incorrect!');
            return back();

        }

       }

       else{
        
        \Session::put('failed','Email is not registered!');
        return back();

       }



   }

   public function user_logout()
   {

        Session::flush();
        Auth::logout();
        return Redirect('home');

   }

   public function product_detail($id)
   {

    $product_detail=Product::where('id',$id)->get();

    return view('user.pages.product_detail',compact('product_detail'));

   }

   public function add_cart($id)
   {

    $user_id=session('userId');
    $product=Product::where('id',$id)->get();
    $instrument_id=$id;

    $cart=new Cart();

    $cart->user_id=$user_id;
    $cart->i_id=$id;
    $cart->i_price=$product[0]->price;
    $cart->save();

    return back();


   }

//    public function user_cart()
//    {
//     $user_id=session('userId');
//     $cart_items=Cart::where('user_id',$user_id)->join('products','carts.i_id','=','products.id')->get();
//     $price=0;
//     $instru_id='';
//     foreach($cart_items as $item){

//         $price=$price+$item->price;
//         $instru_id=$instru_id.$item->i_id.',';
//     }



  
//     // return view('user.pages.user_cart',compact('cart_items','price','instru_id'));
//     return view('user.pages.user_cart');
//    }



   public function stripe(Request $request)
   {

    $user_id=session('userId');
    $instrument_id=explode(',',$request->instrument_id);
    $distinct_price=explode(',',$request->distinct_price);
    $price=$request->price;

  for($i=0;$i<count($instrument_id)-1;$i++){
    DB::table('carts')->insert([
        'user_id'=>$user_id,
        'i_id'=>$instrument_id[$i],
        'i_price'=>$distinct_price[$i],
    ]);
  }



    return view('user.pages.stripe',compact('user_id','instrument_id','price'));

   }


   public function stripePost(Request $request)
   {


    $user_id=session('userId');
    $cart=Cart::where('user_id',$user_id)->get();
    $price=0;
    foreach($cart as $data){
        $price=$price+$data->i_price;
    }


  
    \Stripe\Stripe::setApiKey('sk_test_51LhYTIBe9GmrXLTSdYSqPjHEhjimJngEmZZPAad5OHPEqwD6YmzoxyDZUjfAp1EqwNhwFzxaC97kulyEu0VQO1E600jskfE1cr');
       \Stripe\Charge::create([
      'amount'=>$price*100,
      'currency' => 'usd',
      'source' => $request->input('stripeToken'),
      'description' =>'Payment for renting instrument...'

  ]);

  
    foreach($cart as $item){

            Order::Create([
                'user_id'=>$user_id,
                'instrument_id'=>$item->i_id,
                'price'=>$item->i_price,
                'status'=>'Ordered'
    
          ]);
                
        }

        
    session()->forget('cart');


     Cart::where('user_id',$user_id)->delete();
     return view('user.pages.payment_success');




   }


   public function my_order()
   {
    $user_id=session('userId');
    $data=Order::where('user_id',$user_id)->join('products','orders.instrument_id','=','products.id')->orderBy('orders.id','desc')->get();
    // return $data;
    return view('user.pages.my_order',['data'=>$data]);
   }


   public function add_cart_session($id)
   {
    $product=Product::find($id);

    // $price=0;
    // foreach(session('cart') as $item){
    //     $price=$price+$product->price;
    // }
    // return $price;

    $cart=session()->get('cart');

    $cart[$id]=[
        'id'=>$id,
        'name'=>$product->name,
        'price'=>$product->price,
        'image'=>$product->image,
        'description'=>$product->description,
    ];

  

    session()->put('cart',$cart);

    return redirect()->back();

   }

   public function user_cart()
   {
    // $values=session('cart');
    return view('user.pages.user_cart');
   }

   public function remove_item($id)
   {

        if($id) {

            $cart = session()->get('cart');

            if(isset($cart[$id])) {

                unset($cart[$id]);

                session()->put('cart', $cart);
            }


   }

        return redirect()->back();

  }

}
