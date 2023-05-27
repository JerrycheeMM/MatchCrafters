<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;

    const DIRECTION_SEND = 'SEND';
    const DIRECTION_RECEIVE = 'RECEIVE';

    const TYPE_MONEY_ADDED = 'MONEY_ADDED';
    const TYPE_QRPAY = 'QRPAY';
    const TYPE_CARD_TRANSACTION = 'CARD_TRANSACTION';
    const TYPE_CASH_WITHDRAWAL = 'CASH_WITHDRAWAL';

    const STATUS_REJECTED = 'STATUS_REJECTED';
    const STATUS_PENDING = 'STATUS_PENDING';
    const STATUS_SUCCESS = 'STATUS_SUCCESS';


    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
