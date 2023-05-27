<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'issuer_id_number' => $this->issuer_id_number,
            'card_holder_name' => $this->card_holder_name,
            'is_active' => $this->is_active,
            'expiry_date' => $this->expiry_date,
            'created_at' => $this->created_at,
            'card_design_id' => $this->card_design_id,
        ];
    }
}
