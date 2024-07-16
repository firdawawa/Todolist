<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BudgetController extends Controller
{
    public function index()
    {
        $budget = Budget::all();
        if($budget->count() > 0){
            return response()->json([
                'status' => 200,
                'budget' => $budget
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
            'date' => 'required|string|max:191',
            'criteria' => 'required|string|max:191',
            'category' => 'required|string|max:191',
            'nominal' => 'required|numeric|max_digits:16',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $budget = Budget::create([
                'date' => $request->date,
                'criteria' => $request->criteria,
                'category' => $request->category,
                'nominal' => $request->nominal,
            ]);

            if($budget){

                return response()->json([
                    'status' => 200,
                    'message' => "Budget Track Added Successfully!"
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
        $budget = Budget::find($id);
        if($budget){

            return response()->json([
                'status' => 200,
                'budget' => $budget
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "No Budget Track Found!"
            ], 404);
        }
    }

    public function edit($id)
    {
        $budget = Budget::find($id);
        if($budget){

            return response()->json([
                'status' => 200,
                'budget' => $budget
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "No Budget Track Found!"
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|string|max:191',
            'criteria' => 'required|string|max:191',
            'category' => 'required|string|max:191',
            'nominal' => 'required|numeric|max_digits:16',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $budget = Budget::find($id);

            if($budget){
                $budget->update([
                    'date' => $request->date,
                    'criteria' => $request->criteria,
                    'category' => $request->category,
                    'nominal' => $request->nominal,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Budget Track Updated Successfully!"
                ], 200);
            }else{

                return response()->json([
                    'status' => 404,
                    'message' => "No Budget Track Found!"
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $budget = Budget::find($id);

        if($budget){

            $budget->delete();
            return response()->json([
                'status' => 200,
                'message' => "Budget Track Deleted Successfully!"
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "No Budget Track Found!"
            ], 404);
        }
    }
}
