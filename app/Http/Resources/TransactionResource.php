<?php

namespace App\Http\Resources;

use App\Models\Transaction;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $request->user();

        return [
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'direction' => $this->sender_id == $user->id ? Transaction::DIRECTION_SEND : Transaction::DIRECTION_RECEIVE,
            'type' => $this->type,
            'currency' => $this->currency,
            'description' => $this->description,
            'status' => $this->status,
            'amount' => $this->amount,
        ];
    }
}
