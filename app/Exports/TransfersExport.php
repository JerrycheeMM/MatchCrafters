<?php

namespace App\Exports;

use App\Filters\TransfersFilter;
use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransfersExport implements FromCollection, withMapping, withHeadings
{
    use Exportable;

    protected $user;
    protected $transactions;

    public function __construct($transactions, $user)
    {
        $this->transactions = $transactions;
        $this->user = $user;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function map($transaction): array
    {
        $user = $this->user;
        return [
            $transaction->id,
            $transaction->sender->name,
            $transaction->receiver->name,
            $transaction->description,
            $transaction->status,
            $transaction->withdrawal_security_code,
            (is_null($user) ? null : $transaction->sender_id == $user->id) ? Transaction::DIRECTION_SEND : Transaction::DIRECTION_RECEIVE,
            $transaction->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'Sender Name',
            'Beneficiary Name',
            'Description',
            'Status',
            'Withdrawal Security Code',
            'Type',
            'created At'
        ];
    }
}
