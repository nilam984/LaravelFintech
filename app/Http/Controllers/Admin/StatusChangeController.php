<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlobalService;
use App\Models\Scheme;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;

class StatusChangeController extends Controller
{
    public function changeUserStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'status' => 'required'
        ], [
            'id.required' => 'Id is required',
            'status.required' => 'Status is required',
        ]);

        $user = User::findOrFail($request->id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }

        $user->status = $request->status;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully.'
        ]);
    }

    public function changeGlobalServiceStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:global_services,id',
            'status' => 'required'
        ], [
            'id.required' => 'Id is required',
            'status.required' => 'Status is required',
        ]);

        $service = GlobalService::findOrFail($request->id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found.'
            ]);
        }

        $service->status = $request->status;
        $service->save();

        return response()->json([
            'success' => true,
            'message' => 'Service status updated successfully.'
        ]);
    }

    public function changeServiceRequest(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:service_requests,service_id',
            'status' => 'required|in:active,inactive,pending'
        ], [
            'id.required' => 'Id is required',
            'status.required' => 'Status is required',
            'status.in' => 'Invalid Status',
        ]);

        $service = ServiceRequest::findOrFail($request->id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found.'
            ]);
        }

        $service->status = $request->status;
        $service->save();

        return response()->json([
            'success' => true,
            'message' => 'Service status updated successfully.'
        ]);
    }


    public function changeSchemeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:schemes,id',
            'status' => 'required'
        ], [
            'id.required' => 'Id is required',
            'status.required' => 'Status is required',
        ]);

        $service = Scheme::findOrFail($request->id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Scheme not found.'
            ]);
        }

        $service->status = $request->status;
        $service->save();

        return response()->json([
            'success' => true,
            'message' => 'Scheme status updated successfully.'
        ]);
    }
}
