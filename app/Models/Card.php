<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\InteractsWithNanoid;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Card extends Model
{
    use HasFactory;
    use InteractsWithNanoid;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
