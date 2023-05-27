<?php

namespace App\Http\Controllers;

use App\Helpers\RequestFieldCryptoHelper;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public int $maxAttempts = 5;

    /**
     * Validate the user login request.
     * Overridden to decrypt username and password before validation.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     *
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }


    public function attemptLogin(Request $request): bool
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $user = $this->guard()->user();
        $token = $user->createToken(config('app.name'))->accessToken;

//        $user->logoutEverywhere(false);

        return new JsonResponse([
            'message' => 'success',
            'access_token' => $token,
            'email' => $user->email
        ], 200);
    }

    public function logout(Request $request)
    {
        $this->revokeAllTokens($request->user());

        return new JsonResponse([
            'message' => 'success'
        ], 200);
    }

    /**
     * This is for single session login.
     *
     */
    protected function revokeAllTokens($user): void
    {
        $user->logoutEverywhere();
    }
}
