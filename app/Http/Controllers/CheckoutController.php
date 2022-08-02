<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkoutdata;
use App\Models\User;
use Validator;

class CheckoutController extends Controller
{   
    private $enableSandbox = true;

    public function fetchRequest (Request $request) {
        $formData = $request->all();
        $validator = Validator::make( $request->all(),
        [
        'user_id' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'address' => 'required',
        'zip' => 'required',
        'country' => 'required',
        'email' => 'required',
        'city' => 'required',
        'package_type' => 'required',
        'price' => 'required'
        ] );

        if ( $validator->fails() ) {
            return response()->json( [ 'error'=>$validator->errors() ], 401 );
        }
        else {
            $user = User::find($formData['user_id']);
            if(!empty($user)) {
                $checkoutData = new Checkoutdata();
                $checkoutData->user_id = $formData['user_id'];
                $checkoutData->first_name = $formData['first_name'];
                $checkoutData->last_name = $formData['last_name'];
                $checkoutData->address = $formData['address'];
                $checkoutData->zip = $formData['zip'];
                $checkoutData->country = $formData['country'];
                $checkoutData->email = $formData['email'];
                $checkoutData->city = $formData['city'];
                $checkoutData->package_type = $formData['package_type'];
                $checkoutData->price = $formData['price'];
                $checkoutData->save();
                return response()->json( [ 'success'=>['user' => 'Data saved successfully'] ], 200 );
            }
            else {
                return response()->json( [ 'error'=>['user' => 'User not found'] ], 500 );
            }
        }
    }
}