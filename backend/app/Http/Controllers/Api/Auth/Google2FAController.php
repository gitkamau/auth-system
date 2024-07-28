<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Writer;
use App\Models\User;


class Google2FAController extends ApiController
{
    public function showSetupForm()
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $secretKey = $google2fa->generateSecretKey();

        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeUrl = $writer->writeDataUri($google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secretKey
        ));

        return view('auth.2fa_setup', [
            'secretKey' => $secretKey,
            'qrCodeUrl' => $qrCodeUrl,
        ]);
    }

    public function completeSetup(Request $request)
    {
        $request->validate([
            'secret_key' => 'required|string',
            'one_time_password' => 'required|digits:6',
        ]);

        $google2fa = app('pragmarx.google2fa');

        if ($google2fa->verifyKey($request->secret_key, $request->one_time_password)) {
            $user = Auth::user();
            $user->google2fa_secret = $request->secret_key;
            $user->save();

            return redirect()->route('home')->with('status', '2FA setup completed.');
        }

        return back()->withErrors(['one_time_password' => 'The provided OTP is incorrect.']);
    }

    public function showVerifyForm()
    {
        return view('auth.2fa_verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|digits:6',
        ]);

        $google2fa = app('pragmarx.google2fa');
        $user = Auth::user();

        if ($google2fa->verifyKey($user->google2fa_secret, $request->one_time_password)) {
            session(['2fa_verified' => true]);
            return redirect()->intended();
        }

        return back()->withErrors(['one_time_password' => 'The provided OTP is incorrect.']);
    }
}
