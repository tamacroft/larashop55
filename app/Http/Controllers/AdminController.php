<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\products;
class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function profile(){
        return view('admin.profile');
    }

    public function addProduct(){
      return view('admin.addProduct');
    }

    public function saveProduct(Request $request){
      $pro_name = $request->pro_name;
      $pro_code = $request->pro_code;
      $pro_price = $request->pro_price;
      $pro_info = $request->pro_info;
      $cat_id = $request->cat_id;
      if(isset($request->id)){
        //update the pro
        $id = $request->id;
        $add_product = DB::table("products")->where('id',$id)
        ->update([
          'pro_name' => $pro_name,
          'pro_code' => $pro_code,
          'pro_info' => $pro_info,
          'pro_price' => $pro_price,

          //'pro_img' => "img.jpg",
          //'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
      }else{
        // now insert the new Product
      $add_product = DB::table("products")->insert([
        'pro_name' => $pro_name,
        'pro_code' => $pro_code,
        'pro_price' => $pro_price,
        'pro_info' => $pro_info,
        'cat_id' => $cat_id,
        'pro_img' => "img.jpg",
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
          'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
      ]);
    }
      if($add_product){
        echo "done";
      }else{
        echo "Error";
      }
    }

    public function uploadPP(Request $request){
      $pic = $request->file('pic');
      $filename = $pic->getClientOriginalName();
      $filename = time(). $filename;
      $path = 'public/img';
      $id = $request->id;
      $pic->move($path,$filename);
      //update command
      $update = DB::table('products')->where('id',$id)
      ->update(['pro_img' => $filename]);

      if($update){
        // if everything is going right
        // rediect to edit product of this pro id
        return view('admin.editProduct',[
          'data' => products::where('id',$id)->get()
        ]);
      }else{
        //show odbc_errormsg
        echo "Error";
      }

    }

    public function saveCategory(Request $request){
      $cat_name = $request->cat_name;

      $add_cat = DB::table('cats')->insert([
        'cat_name' => $cat_name,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),

      ]);
      if($add_cat){
        echo "done";
      }else{
        echo "error";
      }
    }




}
