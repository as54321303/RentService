<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Owner;
// use App\Models\Product;
class OwnerController extends Controller
{




    public function owner_register(Request $request)
    {


        $validator = Validator::make($request->all(), [ 
            'name'=>'required',
			'email'=>'required|email|unique:owners,email',
            'password'=>'required',
            'contact'=>'required|unique:owners,contact'
  
		  ]);
  
  
  
		   if ($validator->fails()){
  
			  return response()->json([ 

					  'response_code' => 401,
					  'response_message' => $validator->errors() 

				  ],401);  
		  }



          $user=Owner::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'contact'=>$request->contact
          ]);

          $token=$user->createToken($request->email)->plainTextToken;


          return response()->json([
             'token'=>$token,
             'response_message'=>'Registration Successfull',
             'response_code'=>200, 

          ],200);




    }







    public function owner_login(Request $request)
    {
      
        $validator = Validator::make($request->all(), [ 

			'email'=>'required',
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

        //   if(Auth::guard('owner')->attempt(['email'=>$request->email,'password'=>$request->password])){
        //      $user=Auth::guard('owner')->user();

        //      $token=$user->createToken('rentService',['owner'])->plainTextToken;


        //      return response()->json([
        //         'token'=>$token,
        //         'response_message'=>'Login Success',
        //         'response_code'=>200,    

        //      ],200);
        //   }


              $check=Owner::where('email',$request->email)->orWhere('contact',$request->email)->exists();

              if($check)
              {

               $owner=Owner::where('email',$request->email)->orWhere('contact',$request->email)->first();

                   if(Hash::check($request->password, $owner->password))
                   {


                          $token=$owner->createToken($request->email)->plainTextToken;
                          
                          return response()->json([
                            'token'=>$token,
                            'response_message'=>'Ok',
                            'response_code'=>200,

                           ],200);

                   } 

                   else{

                              return response()->json([

                                'response_message'=>'Invalid Password',
                                'response_code'=>401,

                               ],401);


                   }

              }

          else{

            return response()->json([
                'response_message'=>'Invalid email or contact!',
                'response_code'=>400,    

             ],400);

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
            'power'=>'required',
            'soil_type'=>'required',
            'capacity'=>'required',
            'invoice'=>'required|mimes:pdf',
            'price'=>'required',
            'on_basis'=>'required',
            'transportation_charge'=>'required',
            'id_proof'=>'required',

            'machine_image'=>'required',
  
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

          
          $owner_id=Auth::user()->id;

          if($request->file('invoice')){ 
           $invoice =$request->invoice->getClientOriginalName();
           $request->invoice->move(public_path('products/invoice'),$invoice);
           $product_invoice=url('public/products/invoice').'/'.$invoice;
           }

           if($request->file('id_proof')){

            $id_proof=$request->id_proof->getClientOriginalName();
            $request->id_proof->move(public_path('products/id_proof'),$id_proof);
            $id_proof=url('public/products/id_proof').'/'.$id_proof;

           }


           $features= implode(',,',$request->features);
           $applications=implode(',,',$request->applications);


           $id=DB::table('machines')->insertGetId(array(

            
                'machine_category'=>$request->machine_category,
                'model'=>$request->model,
                'city'=>ucfirst($request->city),
                'manufactured_year'=>$request->manufactured_year,
                'serial_no'=>$request->serial_no,
                'reg_no'=>$request->reg_no,
                'fuel_type'=>ucfirst($request->fuel_type),
                'owner_id'=>$owner_id,
                'invoice'=>$product_invoice,
                'power'=>$request->power,
                'soil_type'=>$request->soil_type,
                'insurance'=>$request->insurance,
                'capacity'=>$request->capacity,
                'id_proof'=>$id_proof,
                'features'=>$features,
                'applications'=>$applications,
                
           ));





           if($id){


            // Machine Image

               if($request->file('machine_image')){

                for($i=0;$i<count($request->file('machine_image'));$i++){

                    $image = $request->machine_image[$i]->getClientOriginalName();
              
                    $request->machine_image[$i]->move(public_path('products/images'),$image);
                    $machine_image=url('public/products/images').'/'.$image;



                             
                    DB::table('images')->insert([
            
                        'image'=>$machine_image,
                        'machine_id'=>$id,
    
                    ]);



        
                }

        }

                     
                     DB::table('machine_prices')->insert([

                        'machine_id'=>$id,
                        'owner_id'=>$owner_id,
                        'price'=>$request->price,
                        'on_basis'=>$request->on_basis,
                        'transportation_charge'=>$request->transportation_charge,

                     ]);
                    





                return response()->json([

                    'response_code'=>200,
                    'response_message'=>'Machine Added'
    
    
                ],200);


               }


    }


    

    public function my_machines()
    {
        $owner_id=auth()->user()->id;
        $machines=DB::table('machines')->where('owner_id',$owner_id)->get();

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



    public function requestedMachine()
    {

        $ownerId=auth()->user()->id;
        return $ownerId;

        
    } 
}
