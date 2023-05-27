<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prefund extends Model
{
    use HasFactory;

    public function prefundUser()
    {
        return $this->belongsTo(User::class, 'prefund_user_id');
    }

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
}
