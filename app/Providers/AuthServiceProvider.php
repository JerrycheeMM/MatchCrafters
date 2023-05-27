<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\PersonalAccessTokenResult;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }

    public function createToken($user, $scopes = [])
    {
        $accessToken = $user->createToken(
            'My Token Name',
            $scopes
        );

        // Remove the existing token if you want to reuse the same token
        $user->tokens()->where('name', 'My Token Name')->delete();

        $token = $accessToken->token;
        $token->expires_at = null; // Set the token expiration as null to make it reusable
        $token->save();

        return new PersonalAccessTokenResult(
            $accessToken->accessToken,
            $token
        );
    }
}
