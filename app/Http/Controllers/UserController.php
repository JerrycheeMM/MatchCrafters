<?php

namespace App\Http\Controllers;

use App\Http\Resources\CardResource;
use App\Http\Resources\QRUserResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return new UserResource($user);
    }

    public function qrLink(Request $request)
    {
        $user = $request->user();

        return new QRUserResource($user);
    }

    public function qrUser(Request $request, $accountNumber)
    {
        $user = User::where('account_number', $accountNumber)->first();

        return new QRUserResource($user);
    }
}
