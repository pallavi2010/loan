<?php

namespace App\Interfaces;
 
interface LoanPaymentRepositoryInterface 
{
    public function createLoanPayment(array $loanPaymentDetails);

    public function getfirstPendingRecord($loan_id);

    public function markPaid($id);

    public function getUnpaid($loan_id);
}