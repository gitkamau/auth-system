<?php
namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Validator;
use Twilio\Http\CurlClient;
use App\Http\Controllers\Api\ApiController;

class MfaController extends ApiController
{

    public function verifyMfaCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mfa_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        Session::put('mfa_verified', true);

        return $this->isMfaCodeValid($request->mfa_code);
    }

    public function sendMfaCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Store the phone number in the session
        Session::put('phone_number', $request->phone_number);
        
        $options = array(
            CURLOPT_CAINFO => storage_path('cacert.pem')
        );
        $http = new CurlClient($options);

        $client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'), null, null, $http);

        try {
            $verification = $client->verify->v2->services(env('TWILIO_VERIFY_SERVICE_SID'))
                ->verifications
                ->create($request->phone_number, 'sms');
            
            return response()->json([$verification->status]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'errors' => [
                    'phone_number' => 'Failed to send MFA code.',
                    'message' => $e->getMessage()
                ]
            ]);
        }
    }

    protected function isMfaCodeValid($mfaCode)
    {
        $client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        try {
            $verificationCheck = $client->verify->v2->services(env('TWILIO_VERIFY_SERVICE_SID'))
                ->verificationChecks
                ->create([
                    'to' => session('phone_number'),
                    'code' => $mfaCode
                ]);
            return $verificationCheck->status;
        } catch (\Exception $e) {
            return false;
        }
    }
}