<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
    use HasFactory;

    protected $fillable = [
       
        'loan_id',
        'amount', 
        'payment_date',
        'status',

    ]; 
    public function Loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
