<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Traits\InteractsWithNanoid;

class Transaction extends Model
{
    use HasFactory, InteractsWithNanoid;

    public $nanoidLength = 8;

    const DIRECTION_SEND = 'SEND';
    const DIRECTION_RECEIVE = 'RECEIVE';

    const TYPE_MONEY_ADDED = 'MONEY_ADDED';
    const TYPE_QRPAY = 'QRPAY';
    const TYPE_CARD_TRANSACTION = 'CARD_TRANSACTION';
    const TYPE_CASH_WITHDRAWAL = 'CASH_WITHDRAWAL';

    const STATUS_REJECTED = 'REJECTED';
    const STATUS_PENDING = 'PENDING';
    const STATUS_SUCCESS = 'SUCCESS';

    protected $guarded = [];


    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
