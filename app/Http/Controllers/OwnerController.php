<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Owner;
use App\Models\Product;

class OwnerController extends Controller
{
    public function owner_dashboard()
    {
        return view('owner.pages.dashboard');
    }

    public function owner_register()
    {
        return view('owner.auth.register');
    }

    public function post_owner_register(Request $request)
    {
        $request->validate([

            'name'=>'required',
            'email'=>'required|email|unique:owners,email',
            'password'=>'required|min:5|max:30',
            'contact'=>'required'

        ]);

        Owner::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'password'=>Hash::make($request->password),

        ]);

        $owner=Owner::where('email',$request->email)->get();

        session()->put('machineOwnerId',$owner[0]->id);

        return redirect('owner-dashboard');

    }

    public function owner_login()
    {
        return view('owner.auth.login');
    }

    public function post_owner_login(Request $request){
        
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);


        $email_check=Owner::where('email',$request->email)->get()->count();

        if($email_check){

            $pass_check=Owner::where('email',$request->email)->get();

            if(Hash::check($request->password,$pass_check[0]->password)){

                session()->put('machineOwnerId',$pass_check[0]->id);

                return redirect('owner-dashboard');


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

    public function owner_logout()
    {
        session()->forget('machineOwnerId');
        Auth::logout();
        return redirect('home');
    }

    public function products()
    {
        $owner_id=session('machineOwnerId');
        $products=DB::table('products')->where('owner_id',$owner_id)->orderBy('id','desc')->get();
        return view('owner.pages.products.index',compact('products'));
    }

    public function add_product()
    {
        return view('owner.pages.products.add_product');

    }

    public function post_add_product(Request $request)
    {

        $owner_id=session('machineOwnerId');

        $product=new Product();
       
        if($request->file('file')){
            $imageName = time().'.'.$request->file->extension();
            $request->file->move(public_path('products/image'),$imageName);
            $product->image=url('public/products/image').'/'.$imageName;
            }
    
            $product->name=$request->p_name;
            $product->description=$request->p_description;
            $product->price=$request->p_price;
            $product->owner_id=$owner_id;
            $product->save();
    
            \Session::put('success','Instrument Added Successfully.');
            return redirect('add-product');
    }

    public function delete_product($id){

        $owner_id=session('machineOwnerId');
        Product::where('owner_id',$owner_id)->where('id',$id)->delete();

        \Session::put('success','Machine Deleted Successfully.');

        return back();
         
    }

    public function update_product(Request $request)
    {
       $owner_id=session('machineOwnerId');
       Product::where('owner_id',$owner_id)->where('id',$request->id)->update([

            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,

       ]);

       \Session::put('success','Machine Details Updated Successfully.');


       return redirect()->back();
    }
}


