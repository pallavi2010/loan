<?php

namespace App\Interfaces;

interface LoanRepositoryInterface 
{ 
    public function getAll();
    public function getLoanById($loanid);
    public function createLoan(array $loanDetails);
    public function updateLoan($loanid, array $newDetails);
    public function calculateRepaymentAmount($loanid);
   
}