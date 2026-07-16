<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlobalService;
use App\Models\User;
use Illuminate\Http\Request;

class StatusChangeController extends Controller
{
    public function changeUserStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
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
}
