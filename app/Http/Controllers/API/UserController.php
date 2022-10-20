<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Machine;
class UserController extends Controller
{


    public function user_register(Request $request)
    {


        $validator = Validator::make($request->all(), [ 
            'name'=>'required',
            'contact'=>'required|unique:users,contact',
		      	'email'=>'required|email|unique:users,email',
            'password'=>'required',
            'confirm_password'=>'required|same:password',
            'bName'=>'required',
            'city'=>'required',
            'bAddress'=>'required',
            'pAddress'=>'required',
  
          ]);
      
      
      
          if ($validator->fails()){
      
            return response()->json([ 

                'response_code' => 401,
                'response_message' => $validator->errors() 

              ],401);  
          }



          $user=User::create([
            'name'=>$request->name,
            'contact'=>$request->contact,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'bName'=>$request->bName,
            'city'=>$request->city,
            'bAddress'=>$request->bAddress,
            'pAddress'=>$request->pAddress,

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


          $email_check=User::where('email',$request->email)->orWhere('contact',$request->email)->get()->count();

          if($email_check){

            $user=User::where('email',$request->email)->orWhere('contact',$request->email)->first();

                  
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
                'response_message'=>'Email or contact is not exist!',
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

    public function newMachines()
    {

      $oldDate=Carbon::now()->subMonth(1)->toDateTimeString();
     
      $machines=Machine::where('machines.created_at','>=',$oldDate)->where('machines.isApproved',1)
      ->join('images','machines.id','=','images.machine_id')->get();


        return response()->json([
          'response_message'=>'Ok',
          'response_code'=>200,
          'data'=>$machines,

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

      $category=DB::table('machine_category')->get(['id','category']);

      return response()->json([
        'data'=>$category,
        'response_message'=>'Ok',
        'response_code'=>200,

    ],200);

    }


    public function find_by_category(Request $request)
    {
          $category=$request->category_id;

          $machines=Machine::where('machine_category',$category)->get();


          return response()->json([
            'data'=>$machines,
            'response_message'=>'Ok',
            'response_code'=>200,

         ],200);

    }


    public function change_password(Request $request)
    {


                  $validator = Validator::make($request->all(), [ 

                    'old_password'=>'required',
                    'new_password'=>'required',
                    'confirm_new_password'=>'required|same:new_password',

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


              $user_id=auth()->user()->id;


                 $pass_check=User::where('id',$user_id)->first();

                 if(Hash::check($request->old_password,$pass_check->password)){
                  
                  User::where('id',$user_id)->update([
                         'password'=>Hash::make($request->new_password),
                  ]);
                  

                  return response()->json([
                    'response_message'=>"Password changed successfully!",
                    'response_code'=>200,
                  ],200);


                  
                 }


                 else{

                  return response()->json([
                    'response_message'=>"Old Password not matched!",
                    'response_code'=>201,
                  ],201);


                 }

    }


    public function searchMachines(Request $request)
    {
      $machineName=$request->machineName;

      $machines=Machine::where('model','LIKE','%'.$machineName.'%')->get();
      
      if(count($machines))
      {
        return response()->json([
          'response_message'=>'ok',
          'response_code'=>200,
          'data'=>$machines,
        ],200);
      }


      else{

        return response()->json([
          'response_message'=>'Machine not found!',
          'response_code'=>404,
        ],404);

      }

    }


        public function filter_machine(Request $request)
        {

           $details=Machine::join('machine_prices','products.id','=','machine_prices.machine_id')
           ->where('products.machine_category',$request->machine_category)
           ->where('products.city',$request->city)
           ->where('products.soil_type',$request->soil_type)
           ->where('machine_prices.price','<=',$request->price_range)
           ->where('machine_prices.on_basis',$request->on_basis)->get();

          if(count($details))
          {


            return response()->json([
              'data'=>$details,
              'response_message'=>'Ok',
              'response_code'=>200
            ],200);


          }

          else
          {

            
            return response()->json([
              'response_message'=>'Machine not found',
              'response_code'=>404
            ],404);


          }

        }



        public function machine_request(Request $request)
        {

         $id= DB::table('machine_request')->insert([


            'user_id'=>$user_id,
            'machine_id'=>$request->machine_id,
            'rent_from'=>$request->rent_from,
            'rent_to'=>$request->rent_to,
            'price'=>$request->price,
            'on_basis'=>$request->on_basis,
            'delivery_address'=>$request->delivery_address,



          ]);

          if($id)
          {
            return response()->json([
              'response_message'=>'Request sent',
              'response_code'=>200
            ],200);
          }

          else{

            return response()->json([
              'response_message'=>'Some error occured',
              'response_code'=>401
            ],401);


          }




        }

}
