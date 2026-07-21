<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\AssignedScheme;
use App\Models\GlobalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Scheme;
use App\Models\SchemeRule;
use App\Models\SchemeRules;
use App\Models\ServiceProduct;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SchemeController extends Controller
{
    public function scheme()
    {
        $users = User::where('role', 'user')->orderBy('id', 'desc')->get();
        $schemes = Scheme::where('status', 1)->latest()->get();
        $services = GlobalService::where('status', 1)->latest()->get();
        return view('admin.scheme', compact('users', 'services', 'schemes'));
    }


    public function storeOrUpdate(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'rules' => 'required|array|min:1',
            'rules.*.service_id' => 'required|exists:global_services,id',
            'rules.*.product_id' => 'required|exists:service_products,id',
            'rules.*.fee_type' => 'required|in:Fixed,Percent',
            'rules.*.start_value' => 'required|numeric',
            'rules.*.end_value' => 'required|numeric|gte:rules.*.start_value',
            'rules.*.fee' => 'required|numeric',
            'rules.*.min_fee' => 'required|numeric',
            'rules.*.max_fee' => 'required|numeric',
            'rules.*.status' => 'required|in:0,1',
        ], [
            'name.required' => 'Scheme name is required.',
            'name.string' => 'Scheme name must be a valid name.',

            'rules.required' => 'At least one rule is required.',
            'rules.array' => 'Rules must be provided as an array.',
            'rules.min' => 'At least one rule must be added.',

            'rules.*.service_id.required' => 'Service is required for each rule.',
            'rules.*.service_id.exists' => 'Selected service does not exist.',

            'rules.*.product_id.required' => 'Product is required for each rule.',
            'rules.*.product_id.exists' => 'Selected product does not exist.',

            'rules.*.fee_type.required' => 'Fee type is required.',
            'rules.*.fee_type.string' => 'Fee type must be a valid text.',

            'rules.*.start_value.required' => 'Start value is required.',
            'rules.*.start_value.numeric' => 'Start value must be a number.',

            'rules.*.end_value.required' => 'End value is required.',
            'rules.*.end_value.numeric' => 'End value must be a number.',
            'rules.*.end_value.gte' => 'End value must be greater than or equal to start value.',

            'rules.*.fee.required' => 'Fee is required.',
            'rules.*.fee.numeric' => 'Fee must be a number.',

            'rules.*.min_fee.required' => 'Minimum fee is required.',
            'rules.*.min_fee.numeric' => 'Minimum fee must be a number.',

            'rules.*.max_fee.required' => 'Maximum fee is required.',
            'rules.*.max_fee.numeric' => 'Maximum fee must be a number.',

            'rules.*.status.required' => 'Status is required.',
            'rules.*.status.in' => 'Status must be either active or inactive.',
        ]);

        DB::beginTransaction();

        try {
            $updatedBy = Auth::user()->id;

            $scheme = Scheme::updateOrCreate(
                [
                    'id' => $request->scheme_id
                ],
                [
                    'name' => $request->name,
                    'updated_by' => $updatedBy
                ]
            );

            SchemeRules::where('scheme_id', $scheme->id)->delete();

            foreach ($request->rules as $rule) {
                SchemeRules::create([
                    'scheme_id' => $scheme->id,
                    'service_id' => $rule['service_id'],
                    'product_id' => $rule['product_id'],
                    'fee_type' => $rule['fee_type'],
                    'start_value' => $rule['start_value'],
                    'end_value' => $rule['end_value'],
                    'fee' => $rule['fee'],
                    'min_fee' => $rule['min_fee'],
                    'max_fee' => $rule['max_fee'],
                    'status' => $rule['status'],
                    'updated_by' => $updatedBy
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Scheme saved successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error : ' . $e->getMessage()
            ], 500);
        }
    }


    public function edit($id)
    {
        $scheme = Scheme::with('rules')
            ->where('id', $id)
            ->firstOrFail();

        return response()->json([
            'status' => true,
            'scheme' => $scheme
        ]);
    }



    public function assignScheme(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id'   => 'required|exists:users,id',
            'scheme_id' => 'required|exists:schemes,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $exists = AssignedScheme::where('user_id', $request->user_id)
            ->where('scheme_id', $request->scheme_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => 'error',
                'message' => 'This scheme is already assigned to the selected user.'
            ], 400);
        }

        $scheme = Scheme::find($request->scheme_id);

        if (!$scheme) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Scheme not found.'
            ], 400);
        }

        AssignedScheme::create([
            'user_id'     => $request->user_id,
            'scheme_id'   => $request->scheme_id,
            'updated_by'  => Auth::user()->id
        ]);

        $scheme->is_assigned = 1;
        $scheme->save();


        return response()->json([
            'status'  => 'success',
            'message' => 'Scheme Assigned Successfully',
        ], 200);
    }
}
