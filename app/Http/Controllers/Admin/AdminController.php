<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlobalService;
use App\Models\ServiceProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function allusers()
    {
        return view('admin.all-users');
    }

    public function globalServices()
    {
        return view('admin.global-service');
    }

    public function serviceRequest()
    {
        $users = User::where('role', 'user')->orderBy('id', 'desc')->get();
        return view('admin.service-request', compact('users'));
    }

    public function getProducts($service_id)
    {
        return ServiceProduct::where('service_id', $service_id)
            ->select('id', 'product_name')
            ->get();
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'service_name' => 'required|string|max:255|unique:global_services,service_name',
                'status' => 'required|boolean',
            ]);

            GlobalService::create([
                'service_name' => $request->service_name,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Global Service Added Successfully.',
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Global Service Store Error: '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'service_name' => 'required|unique:global_services,service_name,'.$request->id,
            'status' => 'required',
        ]);
        $service = GlobalService::findOrFail($request->id);
        $service->update([
            'service_name' => $request->service_name,
            'status' => $request->status,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Service Updated Successfully.',
        ]);
    }


    public function addProduct(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'products' => 'required|array|min:1',
            'products.*.product_name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            ServiceProduct::where('service_id', $request->service_id)->delete();
            $insertData = [];
            foreach ($request->products as $product) {
                $insertData[] = [
                    'service_id'  => $request->service_id,
                    'product_name' => trim($product['product_name']),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
            ServiceProduct::insert($insertData);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Products saved successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
}
