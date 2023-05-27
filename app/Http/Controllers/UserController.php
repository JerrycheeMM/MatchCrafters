<?php

namespace App\Http\Controllers;

use App\Http\Resources\CardResource;
use App\Http\Resources\UserResource;
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

        return $user->account_number;
    }
}
