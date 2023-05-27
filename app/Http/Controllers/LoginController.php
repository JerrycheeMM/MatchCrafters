<?php

namespace App\Http\Controllers;

use App\Helpers\RequestFieldCryptoHelper;
use App\Http\Resources\LoginResource;
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
     */
    protected function sendLoginResponse(Request $request)
    {
        $user = $this->guard()->user();
        $token = $user->createToken(config('app.name'))->accessToken;

        return $request->wantsJson() ? new LoginResource($user, $token) : redirect($this->redirectPath());
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
