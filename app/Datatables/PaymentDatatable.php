<?php

namespace App\Datatables;

use App\Models\Payment;

class PaymentDatatable extends Datatable
{
    protected string $model = Payment::class;

    protected array $with = [];

    protected function map(): callable
    {
        
        return function (Payment $payment) {
            return [
                'loan_id' => $payment->loan_id,
                'fee' => $payment->fee,
                'amount' => $payment->amount,
                'payment_date' => $payment->payment_date,
                'status_id' => $payment->status_id,
            ];
        };
    }
}
