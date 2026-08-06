<?php

namespace App\Http\Controllers\User;

use App\Helper\WebHelper;
use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\BussinessInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    protected $webHelper;

    public function __construct(WebHelper $webHelper)
    {
        $this->webHelper = $webHelper;
    }

    public function businessinfo(Request $request)
    {
        $userId = Auth::id();

        $result = $this->webHelper->createUpdateBusiness($request, $userId);

        if ($result['code'] !== 200) {
            return response()->json($result['response'], $result['code']);
        }

        $businessId = $result['business']->id;

        $bank = $this->webHelper->createOrUpdateBankDetail($request, $userId, $businessId);

        return response()->json([
            'status' => true,
            'message' => 'Business and bank details saved successfully.',
            'data' => [
                'business_info' => $result['business'],
                'bank_detail' => $bank,
            ],
        ], 200);
    }
}
