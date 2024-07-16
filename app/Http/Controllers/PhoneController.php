<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhoneController extends Controller
{
    public function index()
    {
        $phones = Phone::all();
        if($phones->count() > 0){
            return response()->json([
                'status' => 200,
                'phones' => $phones
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Records Found!'
            ], 404);
        }
        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'number' => 'required|digits:12',
            'address' => 'required|string|max:191',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $phone = Phone::create([
                'name' => $request->name,
                'number' => $request->number,
                'address' => $request->address,
            ]);

            if($phone){

                return response()->json([
                    'status' => 200,
                    'message' => "Phone Number Added Successfully!"
                ], 200);
            }else{

                return response()->json([
                    'status' => 500,
                    'message' => "Something Went Wrong!"
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $phone = Phone::find($id);
        if($phone){

            return response()->json([
                'status' => 200,
                'phone' => $phone
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "No Phone Number Found!"
            ], 404);
        }
    }

    public function edit($id)
    {
        $phone = Phone::find($id);
        if($phone){

            return response()->json([
                'status' => 200,
                'phone' => $phone
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "No Phone Number Found!"
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'number' => 'required|digits:12',
            'address' => 'required|string|max:191',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $phone = Phone::find($id);

            if($phone){
                $phone->update([
                    'name' => $request->name,
                    'number' => $request->number,
                    'address' => $request->address,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Phone Number Updated Successfully!"
                ], 200);
            }else{

                return response()->json([
                    'status' => 404,
                    'message' => "No Phone Number Found!"
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $phone = Phone::find($id);

        if($phone){

            $phone->delete();
            return response()->json([
                'status' => 200,
                'message' => "Phone Number Deleted Successfully!"
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "No Phone Number Found!"
            ], 404);
        }
    }
}
