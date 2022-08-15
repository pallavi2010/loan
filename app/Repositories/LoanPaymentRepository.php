<?php

namespace App\Repositories;

use App\Interfaces\LoanPaymentRepositoryInterface;
use App\Models\LoanPayment;
use Illuminate\Support\Facades\Auth;
 
class LoanPaymentRepository implements LoanPaymentRepositoryInterface 
{
    public function createLoanPayment(array $loanPaymentDetails){

        return LoanPayment::create($loanPaymentDetails);
    }

    public function getfirstPendingRecord($loan_id){

        return LoanPayment::where('loan_id', $loan_id)->where('status',0)->first();
    }
    

    public function markPaid($id){
     
        if(LoanPayment::whereId($id)->update(['status' => '1'])){
            return  LoanPayment::findOrFail($id);
        } else{
            return false;
        }
    }

    public function getUnpaid($loan_id){
        return LoanPayment::where('loan_id', $loan_id)->where('status',0)->count();
    }

}