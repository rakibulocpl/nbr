<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Option;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    /**
     * Create a transaction and update balances.
     *
     * @param array $data
     *   Expected keys: date, in_out ('in'/'out'), type, reference_type, reference_id, payment_method, amount, description
     */
    public static function createTransaction(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Create transaction
            $transaction = Transaction::create($data);

            // 2. Update options
            $amount = floatval($data['amount']);

            $globalBalance = Option::where('option_name', 'global_balance')->first();

            if ($data['in_out'] === 'in') {
                $globalBalance->option_value = $globalBalance->option_value + $amount;
            } elseif ($data['in_out'] === 'out') {
                $globalBalance->option_value = $globalBalance->option_value - $amount;
            }
            // Save updated options
            $globalBalance->save();

            return $transaction;
        });
    }
}
