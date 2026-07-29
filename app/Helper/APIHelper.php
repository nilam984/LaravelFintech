<?php

namespace App\Helper;

use App\Models\AssignedScheme;
use App\Models\BussinessInfo;
use App\Models\GatewayRouting;
use App\Models\GlobalService;
use App\Models\IpWhitelist;
use App\Models\OauthUser;
use App\Models\SchemeRules;
use App\Models\ServiceRequest;
use Exception;
use Illuminate\Http\Request;
use App\Models\PayinTransaction;
use App\Models\PaymentGateway;
use Illuminate\Support\Str;

class APIHelper
{

    // Validate header for client ID and Secret Key
    public function validateHeaderRequest(Request $request, string $type)
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

        $service = GlobalService::where('service_name', $type)->where('status', 1)->first();

        if (!$service) {
            throw new Exception('Service is Temporarily Inactive');
        }

        $user = OauthUser::where('client_id', $username)
            ->where('client_secret', hash('sha512', $password))
            ->where('service_id', $service?->id)
            ->where('status', 1)
            ->first();

        if (!$user) {
            throw new Exception('Invalid Client ID OR Client Secret');
        }

        return [
            'userId' => $user->user_id,
            'serviceId' => $service?->id
        ];
    }


    // Check Kyc verified
    public function checkKycVerified(int $userId)
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


    // Check IP whitelisted for a specific service
    public function checkIpWhiteListed(int $userId, int $serviceId)
    {

        $currentIp = request()->ip();

        $listedIps = IpWhitelist::where('user_id', $userId)
            ->where('service_id', $serviceId)
            ->where('is_deleted', false)
            ->pluck('ip')
            ->toArray();

        $listedIps = array_merge($listedIps, ['127.0.0.1', 'localhost']);


        if (!in_array($currentIp, $listedIps)) {
            throw new Exception("Ip not whitelisted for this service. IP : $currentIp");
        }

        return true;
    }


    //Check service active
    public function checkUserServiceActive(int $userId, int $serviceId)
    {

        $serviceActive = ServiceRequest::where('user_id', $userId)
            ->where('service_id', $serviceId)
            ->where('status', 'active')
            ->exists();


        if (!$serviceActive) {
            throw new Exception("Your Service is not Active");
        }

        return true;
    }


    //Check Scheme Defined
    public function schemeAndFeeTax(int $userId, int $serviceId, $amount)
    {

        $assignedScheme = AssignedScheme::select('scheme_id')
            ->where('user_id', $userId)
            ->first();


        if (!$assignedScheme?->scheme_id) {
            throw new Exception("Scheme not Assigned Contact to Administrator");
        }

        $schemeRules = SchemeRules::where('scheme_id', $assignedScheme?->scheme_id)
            ->where('service_id', $serviceId)
            ->where('start_value', '<=', $amount)
            ->where('end_value', '>=', $amount)
            ->first();

        if (!$schemeRules) {
            throw new Exception("Scheme rule not set Contact to Administrator");
        }


        $fee = 0;
        $tax = 0;
        $finalAmount = 0;
        $taxPercent = 18; // Static GST/Tax

        if ($schemeRules) {

            if ($schemeRules->fee_type === 'Percent') {
                $fee = ($amount * $schemeRules->fee) / 100;
            } else {
                $fee = $schemeRules->fee;
            }

            // If calculated fee is lower than min_fee
            if (!is_null($schemeRules->min_fee) && $fee < $schemeRules->min_fee) {
                $fee = $schemeRules->min_fee;
            }

            // If calculated fee is maximum than max_fee
            if (!is_null($schemeRules->max_fee) && $fee > $schemeRules->max_fee) {
                $fee = $schemeRules->max_fee;
            }


            // Tax is always calculated on the fee
            $tax = ($fee * $taxPercent) / 100;

            // Final net amount after deducting fee and tax
            $finalAmount = $amount - ($fee + $tax);

            return [
                'fee' => floatval($fee),
                'tax' => floatval($tax),
                'finalAmount' => floatval($finalAmount),
            ];
        }
    }



    public function generateReferenceId()
    {
        do {

            $letters = chr(rand(65, 90)) . chr(rand(65, 90));

            // 2. Format current time in Indian timezone (IST) with uppercase AM/PM
            $timestampString = now('Asia/Kolkata')->format('Aymdhis') . mt_rand(100000, 999999);

            $referenceId = $letters . $timestampString;
        } while (PayinTransaction::where('payment_reference_id', $referenceId)->exists());

        return $referenceId;
    }


    public function defaultGateway(string $type)
    {
        $gatewayRouting = GatewayRouting::where('gateway_type', $type)->first();


        if (!$gatewayRouting) {
            throw new Exception("Gateway routing not set Contact to Administrator");
        }

        $gateway = PaymentGateway::find($gatewayRouting->payment_gateway_id);

        if (!$gateway) {
            throw new Exception("Gateway not found Contact to Administrator");
        }


        return $gateway?->gateway_name;
    }
}
