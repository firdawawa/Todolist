<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Notes::all();
        if($notes->count() > 0){
            return response()->json([
                'status' => 200,
                'notes' => $notes
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
            'title' => 'required|string|max:50',
            'desc' => 'required|string|max:1000',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $notes = Notes::create([
                'title' => $request->title,
                'desc' => $request->desc,
            ]);

            if($notes){

                return response()->json([
                    'status' => 200,
                    'message' => "Notes Added Successfully!"
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
        $notes = Notes::find($id);
        if($notes){

            return response()->json([
                'status' => 200,
                'notes' => $notes
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "No Notes Found!"
            ], 404);
        }
    }

    public function edit($id)
    {
        $notes = Notes::find($id);
        if($notes){

            return response()->json([
                'status' => 200,
                'notes' => $notes
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "No Notes Found!"
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:50',
            'desc' => 'required|string|max:1000',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $notes = Notes::find($id);

            if($notes){
                $notes->update([
                    'title' => $request->title,
                    'desc' => $request->desc,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Notes Updated Successfully!"
                ], 200);
            }else{

                return response()->json([
                    'status' => 404,
                    'message' => "No Notes Found!"
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $notes = Notes::find($id);

        if($notes){

            $notes->delete();
            return response()->json([
                'status' => 200,
                'message' => "Notes Deleted Successfully!"
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "No Notes Found!"
            ], 404);
        }
    }
}

