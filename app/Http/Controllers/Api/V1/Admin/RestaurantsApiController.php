<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Restaurant;
use App\RestaurantImage;
use File;
use Redirect;
class RestaurantsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurants = Restaurant::all();
        return $restaurants;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request->input());
        // dd($request->file('image'));
        
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'description' => 'required',
        ]);

        $data = Restaurant::create($request->all());
        // return $data->id;

// function uploadAnyFile($request, $name, $saveName = null, $path = null){
    if($request->file('image')){
        $file = $request->file('image');
        $input['fileName'] = time().'.'.$file->getClientOriginalExtension();
        // dd($input['fileName']);
        $destinationPath = public_path('/restaurant/img/');
        $savefile = $file->move($destinationPath, $input['fileName']);
        if($savefile){    
            $fileName = $input['fileName'];
        }
    }
    else{
        $fileName = null;
    }
        $restaurantImage = new RestaurantImage;
        $restaurantImage->image = $fileName;
        $restaurantImage->restaurant_id = $data->id;
        $restaurantImage->save();
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'description' => 'required',
        ]);
        // dd($request->input());
        
        $restaurant = Restaurant::find($id);
        $restaurant->name = $request->name;
        $restaurant->code = $request->code;
        $restaurant->phone = $request->phone;
        $restaurant->email = $request->email;
        $restaurant->description = $request->description;
        // dd($restaurant);
        $restaurant->save();

        if($request->file('image')){
            $file = $request->file('image');
            $input['fileName'] = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/restaurant/img/');
            $savefile = $file->move($destinationPath, $input['fileName']);
            if($savefile){    
                $fileName = $input['fileName'];
            }
        }
        else{
            $fileName = $request->oldImage;
        }
            // $restaurantImage = RestaurantImage::where('restaurant_id', $request->id);
            // $restaurantImage->image = $fileName;
            // dd($restaurantImage);
            // $restaurantImage->save();
            $dataWhere = [
                'image' => $fileName,
            ];
            $save = RestaurantImage::where('restaurant_id', $id)->update($dataWhere);
            return $restaurant;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Restaurant $restaurant)
    {
        if(isset($restaurant->getImage->image)){
            if(File::exists(public_path('/restaurant/img/').$restaurant->getImage->image))
            {
                // dd(public_path('/restaurant/img/').$restaurant->getImage->image);
                unlink(public_path('/restaurant/img/').$restaurant->getImage->image);
                $restaurant->delete();
            }else{
                // dd(public_path('/restaurant/img/').$restaurant->getImage->image);
                $restaurant->delete();
            }
         }
         $restaurant->delete();
         return $restaurant->id;
        // return Redirect(route('admin.restaurant.index'));
    }
}
