<?php

namespace App\Repositories;

use App\Interfaces\LoanRepositoryInterface;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class LoanRepository implements LoanRepositoryInterface 
{
    public function getAll() 
    {
        if(Auth::User()->is_admin == 1){
            return Loan::all();
        } else{
            return Loan::all()->where('user_id',Auth::User()->id);
        }
        
    }

    public function getLoanById($loanid) 
    {
        return Loan::findOrFail($loanid);
    }


    public function createLoan(array $loanDetails) 
    {
        return Loan::create($loanDetails);
    }

    public function updateLoan($loanid, array $newDetails) 
    {
      
        if(Loan::whereId($loanid)->update($newDetails)){
            return  Loan::findOrFail($loanid);
        } else{
            return false;
        }
        
        
    }

    public function calculateRepaymentAmount($loanid){
        $loan = Loan::findOrFail($loanid);
        if($loan){
            $repaymentAmount=$loan->amount/$loan->term;
            $i=1;
            $termPaymentAmount=[];
            $totalRepayment=0;
            while($i<=$loan->term){
                $termPaymentAmount[$i]= round($repaymentAmount,5);
                $totalRepayment +=$termPaymentAmount[$i];
                $i++;
            }
            $replaymmentLeft=$loan->amount-$totalRepayment;
          
            $termPaymentAmount[$loan->term]=$replaymmentLeft+$termPaymentAmount[ $loan->term];
            return $termPaymentAmount;
        } else{
            return false;
        }
        
    }

   
}