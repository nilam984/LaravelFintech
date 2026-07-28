<?php

namespace App\Helper;

use App\Models\BussinessInfo;
use App\Models\GlobalService;
use App\Models\OauthUser;
use Exception;
use Illuminate\Http\Request;

class APIHelper
{

    public function validateHeaderRequest(Request $request)
    {

        // dd($request->getUser(), $request->getPassword());


        if (!$request->isJson()) {
            throw new Exception('Content-Type must be application/json');
        }

        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Basic ')) {
            throw new Exception('Basic Authentication (Clinent ID and Client Secret) is required');
        }

        // Decode Basic Auth
        $encodedCredentials = substr($authHeader, 6);
        $decodedCredentials = base64_decode($encodedCredentials);

        if (!$decodedCredentials || !str_contains($decodedCredentials, ':')) {
            throw new Exception('Invalid Basic Authentication Credentials');
        }

        [$username, $password] = explode(':', $decodedCredentials, 2);

        $payinService = GlobalService::where('service_name', 'Payin')->where('status', 1)->first();

        if (!$payinService) {
            throw new Exception('Service is Temporarily Inactive');
        }

        $user = OauthUser::where('client_id', $username)
            ->where('client_secret', hash('sha512', $password))
            ->where('service_id', $payinService?->id)
            ->where('status', 1)
            ->first();

        if (!$user) {
            throw new Exception('Invalid Client ID OR Client Secret');
        }

        return [
            'userId' => $user->user_id,
        ];
    }

    public function checkKycVerified($userId)
    {

        $businessInfo = BussinessInfo::where('user_id', $userId)->first();

        if (!$businessInfo) {
            throw new Exception('Business Details not found');
        }

        if (!$businessInfo->kyc_verified) {
            throw new Exception('KYC details are not complete');
        }

        return true;
    }
}
