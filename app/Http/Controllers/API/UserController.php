<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;
class UserController extends Controller
{


    public function user_register(Request $request)
    {


        $validator = Validator::make($request->all(), [ 
            'name'=>'required',
		      	'email'=>'required|email',
            'password'=>'required',
  
		  ]);
  
  
  
		   if ($validator->fails()){
  
			  return response()->json([ 

					  'response_code' => 401,
					  'response_message' => $validator->errors() 

				  ],401);  
		  }


          if(User::where('email',$request->email)->first()){
            return response()->json([

                'response_code'=>201,
                'response_message'=>"Email Already exist!",

            ],201);
          }

          $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
          ]);

          $token=$user->createToken($request->email)->plainTextToken;


          return response()->json([

            'response_code'=>200,
            'response_message'=>"Registration Success",
            'token'=>$token,

        ],200);





    }


    
    public function user_login(Request $request)
    {
      
        $validator = Validator::make($request->all(), [ 

			'email'=>'required|email',
            'password'=>'required',
  
		  ]);
  
  
  
		   if ($validator->fails()){
  
			  return response()->json(
  
				  [
  
					  'response_code' => 401,
  
					  'response_message' => $validator->errors()
  
				  ],
  
				  401
  
			  );
  
		  }


          $email_check=User::where('email',$request->email)->get()->count();

          if($email_check){

            $user=User::where('email',$request->email)->first();

                  
          if(Hash::check($request->password,$user->password)){
          
            $token=$user->createToken($request->email)->plainTextToken;

            return response()->json([
                'response_message'=>'Ok!',
                'response_code'=>200,
                'token'=>$token,

            ],200);
         }
            else
            {
                return response()->json([

                    'response_message'=>'Incorrect Password!',
                    'response_code'=>201,

                ],201);
            }

          }

          else{

            return response()->json([
                'response_message'=>'Email is not exist!',
                'response_code'=>401,

            ],401);

          }
    

        


    }

    public function user_details()
    {

        $user=auth()->user();
        return response()->json([
          'data'=>$user,
          'response_message'=>'Logout Success',
          'response_code'=>200,
        ],200);

    }

    public function machines()
    {

      $products=Product::where('isApproved',1)->get();

      return response()->json([
        'data'=>$products,
        'response_message'=>'Ok',
        'response_code'=>200,

    ],200);

        
    }


    public function add_to_cart($id)
    {


          $product=Product::find($id);
      
          $cart=session()->get('cart');
      
          $cart[$id]=[
              'id'=>$id,
              'name'=>$product->name,
              'price'=>$product->price,
              'image'=>$product->image,
              'description'=>$product->description,
          ];
  
    
  
           session()->put('cart',$cart);


           return response()->json([
            'response_message'=>'Added Successfully',
            'response_code'=>200,

         ],200);


    }



       


    public function user_logout(Request $request)
    {
          auth()->user()->tokens()->delete();

          return response()->json([
            'response_message'=>'Logout Success',
            'response_code'=>200,

        ],200);
    }

    public function categories()
    {

      $category=DB::table('machine_category')->get();

      return response()->json([
        'data'=>$category,
        'response_message'=>'Ok',
        'response_code'=>200,

    ],200);

    }


    public function find_by_category(Request $request)
    {
          $category=$request->category_id;

          $machines=Product::where('machine_category',$category)->get();


          return response()->json([
            'data'=>$machines,
            'response_message'=>'Ok',
            'response_code'=>200,

         ],200);

    }


}
