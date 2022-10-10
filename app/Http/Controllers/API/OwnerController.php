<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Owner;
use App\Models\Product;
class OwnerController extends Controller
{




    public function owner_register(Request $request)
    {


        $validator = Validator::make($request->all(), [ 
            'name'=>'required',
			'email'=>'required|email',
            'password'=>'required',
            'contact'=>'required'
  
		  ]);
  
  
  
		   if ($validator->fails()){
  
			  return response()->json([ 

					  'response_code' => 401,
					  'response_message' => $validator->errors() 

				  ],401);  
		  }


          if(Owner::where('email',$request->email)->first()){
            return response()->json([

                'response_code'=>201,
                'response_message'=>"Email Already exist!",

            ],201);
          }

          $user=Owner::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'contact'=>$request->contact
          ]);

          $token=$user->createToken('rentService',['owner'])->plainTextToken;
          return response()->json([
             'token'=>$token,
             'response_message'=>'Logout Success',
             'response_code'=>200, 

          ],200);




    }







    public function owner_login(Request $request)
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

          if(Auth::guard('owner')->attempt(['email'=>$request->email,'password'=>$request->password])){
             $user=Auth::guard('owner')->user();
             $token=$user->createToken('rentService',['owner'])->plainTextToken;
             return response()->json([
                'token'=>$token,
                'response_message'=>'Login Success',
                'response_code'=>200,    

             ],200);
          }

          else{

            return response()->json([
                'response_message'=>'Invalid Credentials',
                'response_code'=>200,    

             ],200);

          }
        


    }

    public function owner_details()
    {

        $user=Auth::user();
        return response()->json([
            'data'=>$user,
            'response_message'=>'Ok',
            'response_code'=>200,
        ],200);

    }

    

    public function add_machine(Request $request)
    {








        $validator = Validator::make($request->all(), [ 

			'machine_category'=>'required',
            'model'=>'required',
            'city'=>'required',
            'manufactured_year'=>'required',
            'serial_no'=>'required',
            'reg_no'=>'required',
            'fuel_type'=>'required',
            'invoice'=>'required|mimes:pdf',
            // 'machine_image'=>'required',
  
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


          $machine_category=$request->machine_category;
          $model=$request->model;
          $city=$request->city;
          $manufactured_year=$request->manufactured_year;
          $serial_no=$request->serial_no;
          $reg_no=$request->reg_no;
          $fuel_type=$request->fuel_type;
          $invoice=$request->invoice;


          
          $owner_id=Auth::user()->id;
          $product_invoice;

          if($request->file('invoice')){ 
           $invoice = time().'.'.$request->invoice->extension();
           $request->invoice->move(public_path('products/pdf'),$invoice);
           $product_invoice=url('public/products/pdf').'/'.$invoice;
           }

           $id=Product::create([

            'machine_category'=>$machine_category,
            'model'=>$model,
            'city'=>ucfirst($city),
            'manufactured_year'=>$manufactured_year,
            'serial_no'=>$serial_no,
            'reg_no'=>$reg_no,
            'fuel_type'=>ucfirst($fuel_type),
            'owner_id'=>$owner_id,
            'invoice'=>$product_invoice,
            
           ]);


           if($id){


                if($request->file('machine_image')){ 
                $machine_image = time().'.'.$request->machine_image->extension();
                $request->machine_image->move(public_path('products/image'),$machine_image);
                $machine_image=url('public/products/image').'/'.$machine_image;
                }


                 DB::table('images')->insert([
    
                'image'=>$machine_image,
                'product_id'=>$id->id,
    
                 ]);


            //    if($request->file('machine_image')){

            //     foreach(($request->file('machine_image')) as $images ){

            //         if($request->file('machine_image')){ 
            //             $machine_image = time().'.'.$images->machine_image->extension();
            //             $images->machine_image->move(public_path('products/image'),$machine_image);
            //             $machine_image=url('public/products/image').'/'.$machine_image;
            //             }

            //         DB::table('images')->insert([
    
            //             'image'=>$machine_image,
            //             'product_id'=>$id->id,
    
            //         ]);
    
            //     }

            //    }

 

            return response()->json([

                'response_code'=>200,
                'response_message'=>'Machine Added'


            ],200);


           }

           else{


            return response()->json([

                'response_code'=>500,
                'response_message'=>'Some error occured!'


            ],500);



           }



    }


    




    public function my_machines()
    {
        $owner_id=auth()->user()->id;
        $machines=Product::where('owner_id',$owner_id)->get();

        return response()->json([
            'data'=>$machines,
            'response_code'=>200,
            'response_message'=>"ok",

        ]);
    }




    

    public function owner_logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'response_message'=>'Logout Success',
            'response_code'=>200,

        ],200);
    }
}
