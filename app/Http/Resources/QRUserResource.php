<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QRUserResource extends JsonResource
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
            'account_number' => $this->account_number,
            'name' => $this->name,
            'role' => $this->role,
            'business_name' => $this->business_name
        ];
    }
}
