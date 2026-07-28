<?php

namespace App\Http\Controllers\API;

use App\Helper\APIHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayinController extends Controller
{
    protected $apiHelper;

    public function __construct(APIHelper $apiHelper)
    {
        $this->apiHelper = $apiHelper;
    }

    public function payin(Request $request)
    {
        $userId = null;
        try {

            $authData = $this->apiHelper->validateHeaderRequest($request);

            if ($authData['userId']) {
                $userId =  $authData['userId'];
            }

            $this->apiHelper->checkKycVerified($userId);
            return true;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
