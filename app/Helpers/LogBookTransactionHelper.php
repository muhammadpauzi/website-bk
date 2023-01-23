<?php

namespace App\Helpers;

use App\Models\LogBookTransaction as LogBookTransaction;

class LogBookTransactionHelper
{

    public static function addToLog($subject, $userId, $loanId = null, $bookReturnId = null)
    {
        return LogBookTransaction::create([
            'subject' => $subject,
            'ip' => request()->ip(),
            'agent' => request()->header('user-agent'),
            'user_id' => $userId,
            'loan_id' => $loanId,
            'book_return_id' => $bookReturnId,
        ]);
    }


    public static function logActivityLists()
    {
        return LogBookTransaction::latest()->get();
    }
}
