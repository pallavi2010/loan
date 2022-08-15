<?php

namespace App\Http\Resources;

use App\Models\LoanPayment;
use Illuminate\Http\Resources\Json\JsonResource;

class Loan extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
           
            'amount' => $this->amount,
            'term' => $this->term,
            'status' => $this->status,
            'repayments' => $this->payments,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
