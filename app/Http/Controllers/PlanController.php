<?php

namespace App\Http\Controllers;


use App\Models\Plans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
   
    public function create()
    {
        $plans = Plans::where('isActive', 1)->orderBy('created_at','DESC')->get();
        return view('masters/plan',[
            'plans' => $plans
        ]);
    }

    public function store(Request $request){
        
        $rules = [
            'name' => 'required|min:2',
            'code' => 'required|min:2',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('plan.create')->withInput()->withErrors($validator);
        }

        $plan = new Plans();
        $plan->name = $request->name; 
        $plan->code = $request->code;
        $plan->isActive = 1;

        $plan->save();
        return redirect()->route('plan.create')->with('success', 'Plan created successfully');
    }

    public function updateActive($id, Request $request)
    {
        $company = Plans::findOrFail($id);
        $company->isActive = $request->input('isActive');
        $company->save();

        return response()->json(['message' => 'Active status updated successfully', 'success' => true]);
    }
}
