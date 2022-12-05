<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Machine;
class UserController extends Controller
{


    public function signUp(Request $request)
    {


        $validator = Validator::make($request->all(), [ 
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'contact'=>'required|unique:users,contact',
            'password'=>'required',
            'confirm_password'=>'required|same:password',
            'bName'=>'required',
            'city'=>'required',
            'bAddress'=>'required',
            'pAddress'=>'required',
  
          ],
         [


            'email.unique'=>"Email already taken! Please login...",
            'contact.unique'=>"Contact already taken! Please login...",

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

         
          $email = $request->email;

          $otp = rand(1000,9000);
          $insertOTP = User::where('id', $user->id)->update(["otp" => $otp]);


          $data="Hello, ".$email."."." Your verification otp is: ".$otp;

          $mail=mail("$email","Otp Verification",$data,"Kuubs");




            return response()->json([

              'response_code'=>200,
              'response_message'=>"Ok",

          ],200);
  


    }




        public function verifyOtp(Request $request)
        {


          $validator = Validator::make($request->all(), [ 
            'email'=>'required',
            'otp'=>'required',
  
          ]);
      
      
      
          if ($validator->fails()){
      
            return response()->json([ 

                'response_code' => 401,
                'response_message' => $validator->errors() 

              ],401);  
          }




          $otp=$request->otp;

          $email=$request->email;

          $check=User::where('email',$email)->first();
          
          if($otp==$check->otp)
          {

            User::where('email',$email)->update([
              'isActive'=>1,
            ]);
            // $token=$check->createToken($email)->plainTextToken;
            return response()->json([
              'response_message'=>"Ok",
              'response_code'=>"200",
              // 'token'=>$token,
            ],200);
          }

          else{

            return response()->json([
              'response_message'=>"Otp not matched!",
              'response_code'=>"401",
            ],401);

          }

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

      $userCheck=User::where('isActive',0)->where('email',$request->email)->orWhere('contact',$request->contact)->first();


      if($userCheck)
      {

        $email=$userCheck->email;
        $contact=$userCheck->contact;
      
        $otp = rand(1000,9000);
        $insertOTP = User::where('email', $email)->orWhere('contact',$contact)->update(["otp" => $otp]);


        $data="Hello, ".$email."."." Your verification otp is: ".$otp;

        $mail=mail("$email","Otp Verification",$data,"Kuubs");

        if($mail)
        {
          return response()->json([
            'response_message'=>'PLease verify otp to activate your account',
            'response_code'=>200,
          ],200);
        }


      }

      else

      {
          $email_check=User::where('isActive',1)->where('email',$request->email)->orWhere('contact',$request->email)->get()->count();

          if($email_check){

            $user=User::where('isActive',1)->where('email',$request->email)->orWhere('contact',$request->email)->first();

                  
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


    }



    public function forgotPassword(Request $request)
    {


          $validator = Validator::make($request->all(), [ 
            'email'=>'required',

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
      
          $email=$request->email;

          $check=User::where('email',$email)->where('isActive',1)->first();
         
          if($check)
          {

            
          $otp = rand(1000,9000);
          $insertOTP = User::where('email', $email)->update(["otp" => $otp]);


          $data="Hello, ".$email."."." Your verification otp is: ".$otp;

          $mail=mail("$email","Otp Verification",$data,"Kuubs");


         
          return response()->json([ 

            'response_message' =>'Ok',
            'response_code' => 200,
            
          ],200);  

          }

          else

          {

            return response()->json([ 

              'response_message' =>'Email not found!',
              'response_code' => 404,
              
            ],404); 


          }
             

    }



    public function resetPassword(Request $request)
    {
      
      

                          $validator = Validator::make($request->all(), [ 

                            'email'=>'required',
                            'newPassword'=>'required',

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
              
                      $check=User::where('email',$request->email)->update([

                        'password'=>Hash::make($request->newPassword),

                      ]);


                      if($check)
                      {
                        return response()->json([
                          'response_message'=>'Ok',
                          'response_code'=>200
                        ],200);
                      }

                      else
                      {
                        return response()->json([
                          'response_message'=>'Some error occurred!',
                          'response_code'=>500
                        ],500);

                      }

    }




    public function machines()
    {

   
        $machines=Machine::where('machines.isApproved',1)->where('machines.onRent',0)->join('machine_category','machines.machine_category','=','machine_category.id')
        ->join('machine_prices','machines.id','=','machine_prices.machine_id')->join('images','machines.id','=','images.machine_id')
        ->get(['machines.id as machineId','machine_category.category','machines.model','machines.city','machine_prices.pricePerDay','machines.onRent','images.image'])->unique('machineId');


        return response()->json([
          'response_message'=>'Ok',
          'response_code'=>200,
          'data'=>$machines
        ],200);




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

      $validator = Validator::make($request->all(), [ 

        'category_id'=>'required',
   

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
          $category=$request->category_id;

          $machines=Machine::where('machine_category',$category)->get();


          return response()->json([
            'response_message'=>'Ok',
            'response_code'=>200,
            'data'=>$machines,
        

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


        public function filterMachine(Request $request)
        {

          //  $details=Machine::join('machine_prices','products.id','=','machine_prices.machine_id')
          //  ->where('products.machine_category',$request->machine_category)
          //  ->where('products.city',$request->city)
          //  ->where('products.soil_type',$request->soil_type)
          //  ->where('machine_prices.price','<=',$request->price_range)->get();

           $query=Machine::all();

           if($request->machine_category)
           {
            $query->where('machine_category',$request->machine_category)->get('machineName');
           }

           if($request->city)
           {
            $query->where('city',$request->city)->get('machineName');
           }

           return $query->all();

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

          $userId=auth()->user()->id;


         $id= DB::table('machine_request')->insert([


            'user_id'=>$userId,
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

        public function calculatePrice(Request $request)
        {

          $count=$request->count;

          $userCity=$request->city;
          $sourceCity=DB::table('cities')->where('city','=',$userCity)->first();


          $machineCity=Machine::where('id','=',$request->machineId)->first();
          $destinyCity=DB::table('cities')->where('city',$machineCity->city)->first();
          
          $lat1=$sourceCity->lat;
          $long1=$sourceCity->lng;

          $lat2=$destinyCity->lat;
          $long2=$destinyCity->lng;


          $theta = $long1 - $long2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $distance = floor($dist * 60 * 1.1515);

          $price=array();

          if($request->pricePerDay)
          {
            $machinePrice=DB::table('machine_prices')->where('machine_id',$request->machineId)->where('pricePerDay',$request->pricePerDay)->first();

            $transportationCharge=$distance*intval($machinePrice->transportation_charge);

            $totalPrice=$transportationCharge+($machinePrice->pricePerDay)*$count;
  
          }

          if($request->pricePerWeek)
          {
            $machinePrice=DB::table('machine_prices')->where('machine_id',$request->machineId)->where('pricePerWeek',$request->pricePerWeek)->first();

            $transportationCharge=$distance*intval($machinePrice->transportation_charge);

            $totalPrice=$transportationCharge+($machinePrice->pricePerWeek)*$count;
  
          }

          if($request->pricePerMonth)
          {
            $machinePrice=DB::table('machine_prices')->where('machine_id',$request->machineId)->where('pricePerWeek',$request->pricePerWeek)->first();

            $transportationCharge=$distance*intval($machinePrice->transportation_charge);

            $totalPrice=$transportationCharge+($machinePrice->pricePerMonth)*$count;
  
          }

// return $machinePrice;
          
          

          $obj=new \StdClass;
          $obj->totalPrice=$totalPrice;
          $obj->transportationCharge=$transportationCharge;
          

    

          array_push($price,$obj);

          return response()->json([
            'response_message'=>'Ok',
            'response_code'=>200,
            'data'=>$price,
          ],200);




        }


        public function takeOnRent(Request $request)
        {


          $userId=auth()->user()->id;

          $id=DB::table('on_rent')->insertGetId(array(

             'userId'=>$userId,
             'machineId'=>$request->machineId,
             'price'=>$request->price,
             'onBasis'=>$request->onBasis,
             'from'=>$request->from,
             'to'=>$request->to,
             'deliveryAddress'=>$request->deliveryAddress,
             'totalPrice'=>$request->totalPrice


          ));

          DB::table('machines')->update([

            'onRent'=>1

          ]);

           if($id)
           {

            return response()->json([
              'response_message'=>'Ok',
              'response_code'=>200,
            ],200);

           }

           else{

            return response()->json([
              'response_message'=>'Some Error Occured!',
              'response_code'=>404,
            ],404);


           }

        }


        public function sendMail(Request $request)
        {

          $email= $request->email;

          $otp = rand(1000,9000);
          $data = ["email" => $email, "otp" => $otp];
          $user['to'] = $email;
          $success = Mail::send('mail', $data, function ($message) use ($user) { 
              $message->to($user['to']);            
              $message->subject('Forgot password');        
              
              });	

              return "Otp Send";

        }

        public function completedRentPeriod()
        {
            $userId=auth()->user()->id;
            $machines=DB::table('on_rent')->where('userId',$userId)->where('on_rent.rentCompleted',1)
            ->join('machines','on_rent.machineId','=','machines.id')->get();

            return response()->json([
              'response_message'=>'Ok',
              'response_code'=>200,
              'data'=>$machines,
            ],200);

        }


        public function onRent()
        {
            $userId=auth()->user()->id;
            $machines=DB::table('on_rent')->where('userId',$userId)->where('on_rent.rentCompleted',0)
            ->join('machines','on_rent.machineId','=','machines.id')->get();

            return response()->json([
              'response_message'=>'Ok',
              'response_code'=>200,
              'data'=>$machines,
            ],200);

        }

        public function complaint(Request $request)
        {



          $validator = Validator::make($request->all(), [ 

            'complaintImage'=>'required',
            'machineId'=>'required',
            'details'=>'required',

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


          $userId=auth()->user()->id;


          
          $complain=DB::table('complaints')->insert([

            'userId'=>$userId,
            'machineId'=>$request->machineId,
            'details'=>$request->details,

          ]);

          for($i=0;$i<count($request->file('complaintImage'));$i++)
          {


            if($request->file('complaintImage')){ 
              $complaintImage =$request->complaintImage[$i]->getClientOriginalName();
              $request->complaintImage[$i]->move(public_path('products/complaintImages'),$complaintImage);
              $complaint_image=url('public/products/complaintImages').'/'.$complaintImage;
              }

              else{
                $complaint_image=null;
              }



            DB::table('complaint_images')->insert([
              'userId'=>$userId,
              'machineId'=>$request->machineId,
              'image'=>$complaint_image,

            ]);

          }


          if($complain)
          {
            return response()->json([
              'response_message'=>"Complain Raised...",
              'respponse_code'=>200,
            ],200);
          }
         
        }


      


}
