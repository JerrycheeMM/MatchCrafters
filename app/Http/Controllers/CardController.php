<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Http\Resources\CardResource;
use App\Models\Card;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return CardResource::collection($user->cards()->paginate(20));
    }

    public function store(CreateCardRequest $request): CardResource|JsonResponse
    {
        $user = $request->user();
        $computedInput = [
            'currency' => 'MYR',
            'balance' => 0,
            'type' => 'DEBIT',
            'issuer_id_number' => (new Card)->generateNanoid(16),
            'ccv' => (new Card)->generateNanoid(3),
            'is_active' => 1,
            'expiry_date' => Carbon::today()->addYear()
        ];
        $card = new Card(array_merge($request->validated(), $computedInput));
        $user->cards()->save($card);

        return new CardResource($card);
    }

    public function update(UpdateCardRequest $request, $cardId): CardResource|JsonResponse
    {
        $user = $request->user();
        $card = Card::find($cardId);
        $user->cards()->update($request->validated());
        $card->refresh();
        return new CardResource($card);
    }
}
