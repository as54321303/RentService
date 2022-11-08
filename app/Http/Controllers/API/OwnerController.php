<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Owner;
use App\Models\Machine;
class OwnerController extends Controller
{




    public function register(Request $request)
    {

        // return $request->all();
        $validator = Validator::make($request->all(), [ 
            'name'=>'required',
			'email'=>'required|email|unique:owners,email',
            'password'=>'required',
            'confirmPassword'=>'required|same:password',
            'contact'=>'required|unique:owners,contact',
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



          $owner=Owner::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'contact'=>$request->contact,
            'bName'=>$request->bName,
            'city'=>$request->city,
            'bAddress'=>$request->bAddress,
            'pAddress'=>$request->pAddress,
          ]);

          $token=$owner->createToken($request->email)->plainTextToken;


          return response()->json([
            'response_message'=>'Registration Successfull',
            'response_code'=>200,
            'token'=>$token

          ],200);
        
        //   $email = $request->email;

        //   $otp = rand(1000,9000);
        //   $insertOTP = Owner::where('id', $owner->id)->update(["otp" => $otp]);
        //   $data = ["email" => $email, "otp" => $otp];
        //   $user['to'] = $email;
        //   $success = Mail::send('mail', $data, function ($message) use ($user) { 

        //       $message->to($user['to']);            
        //       $message->subject('Otp Verification');        
              
        //       });	


        //     return response()->json([

        //       'response_code'=>200,
        //       'response_message'=>"Please, Verify otp to continue",

        //   ],200);



    }




            public function verifyOtp(Request $request)
            {
            $otp=$request->otp;

            $email=$request->email;

            $check=Owner::where('email',$email)->first();
            
            if($otp==$check->otp)
            {
                $token=$check->createToken($email)->plainTextToken;
                return response()->json([
                'response_message'=>"Ok",
                'response_code'=>"200",
                'token'=>$token,
                ],200);
            }

            else{

                return response()->json([
                'response_message'=>"Otp not matched!",
                'response_code'=>"401",
                ],401);

            }

            }







    public function login(Request $request)
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


    public function states()
    {
        
    }

    public function ownerDetails()
    {

        $user=Auth::user();
        return response()->json([
            'data'=>$user,
            'response_message'=>'Ok',
            'response_code'=>200,
        ],200);

    }

    

    public function addMachine(Request $request)
    {

        // return $request->all();

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
            'pricePerDay'=>'required',
            'pricePerWeek'=>'required',
            'pricePerMonth'=>'required',
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
                        'pricePerDay'=>$request->pricePerDay,
                        'pricePerWeek'=>$request->pricePerWeek,
                        'pricePerMonth'=>$request->pricePerMonth,
                        'transportation_charge'=>$request->transportation_charge,

                     ]);
                    





                return response()->json([

                    'response_code'=>200,
                    'response_message'=>'Machine Added'
    
    
                ],200);


               }


    }


    

    public function myMachines()
    {
        $owner_id=auth()->user()->id;
        $machines=DB::table('machines')->where('owner_id',$owner_id)->get();

        return response()->json([
            'data'=>$machines,
            'response_code'=>200,
            'response_message'=>"ok",

        ]);
    }



    public function logout()
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

    public function onServiceMachines()
    {
        $ownerId=auth()->user()->id;
        $machines=Machine::where('owner_id',$ownerId)->where('onRent',1)->join('on_rent','machines.id','=','on_rent.machineId')
        ->where('on_rent.rentCompleted',0)->get();
       
        return response()->json([
            'response_message'=>'Ok',
            'response_code'=>200,
            'data'=>$machines
        ],200);
    }

  public function searchMachine(Request $request)
  {
    $machineName=$request->machineName;
    $machines=Machine::where('model','LIKE','%'.$machineName.'%')->get();

    return response()->json([

        'response_message'=>'Ok',
        'response_code'=>200,
        'data'=>$machines
    ],200);
  }







  public function googleLogin(Request $request)
  {
      
          // $url = "https://www.googleapis.com/oauth2/v3/userinfo";
          /*
          Android dev are providing us id_token from their app
          */
          $url = "https://oauth2.googleapis.com/tokeninfo";
          $response = Http::get($url, [
              'id_token' => $request->code,
          ]);

          if(!$response->ok()) {
              return response()->json([
                  "response_code" => 402,
                  "response_message" => "Invalid Access Token"
              ], 402);
          } else {
              $email = $response['email'];
              // $email = $response->email;
              $exists = Owner::where('email', $email)->exists();
              if($exists) {
                  $data = Owner::where('email', $email)->first();
                  return response()->json([
                      "response_code" => 200,
                      "response_message" => "Ok",
                      "success" => $data
                  ], 200);
              } else {
             
                          
                          function random_password( $lengthh = 12 ) {
                              $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
                              $password = substr( str_shuffle( $chars ), 0, $lengthh );
                              return $password;
                          }
                          $pass = random_password();
                          $id =Owner::insertGetId(array(
                              'name'=> $response['name'],
                              'email'=>$response['email'],
                              'password'=>$pass,
                              'provider_id' => $response['sub'],
                              'provider_name' => 'GOOGLE'

                          ));

                          $userinfo =Owner::where('id',$id)->first();

                          return response()->json([
                              "response_code" => 201,
                              "response_message" => "New user created",
                              "success" => $userinfo
                          ], 201);
                  }
              
          }

  }




}
