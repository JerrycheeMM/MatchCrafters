<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function receivable(): MorphTo
    {
        return $this->morphTo();
    }
}
