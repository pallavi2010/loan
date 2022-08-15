<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Loan as LoanResource;
use App\Models\Loan;
use App\Models\LoanPayment;
use Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class LoanController extends BaseController
{
    /**
      * Responds to requests to GET /loan/all
   */
    public function index()
    {
        $loans = Loan::all()->where('user_id',Auth::User()->id);
        return $this->handleResponse(LoanResource::collection($loans), 'Loans have been retrieved!');
    }
   
    /**
      * Responds to requests to GET /loan/create
   */
    public function store(Request $request)
    {
        $input = $request->all();
    
        $input['user_id']=Auth::User()->id;
        $input['status']='pending';
        $validator = Validator::make($input, [
            'amount' => 'required',
            'term' => 'required',
            'user_id' => 'required',
        ]);
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }
        $loan = Loan::create($input);

        $loan_id=$loan->id;
        //create weekly loan payments
        if($loan){
            $repaymentAmount=$input['amount']/$input['term'];
            $i=1;
            $termPaymentAmount=[];
            $totalRepayment=0;
            while($i<=$input['term']){
                $termPaymentAmount[$i]= round($repaymentAmount,5);
                $totalRepayment +=$termPaymentAmount[$i];
                $i++;
            }
            $replaymmentLeft=$input['amount']-$totalRepayment;
          
            $termPaymentAmount[$loan->term]=$replaymmentLeft+$termPaymentAmount[ $loan->term];
            $days=7;
            foreach($termPaymentAmount as $key=>$term_payment){
                $daysToAdd=$days*$key;
                $currentDateTime = Carbon::now();
                $newDateTime = Carbon::now()->addDays($daysToAdd)->toDateString ();
         
                $data['amount']=$term_payment;
                $data['status']=0;
                $data['payment_date']= $newDateTime;
                $data['loan_id']=$loan_id; 
                $loanPayment = LoanPayment::create($data);
            }



        }
        return $this->handleResponse(new LoanResource($loan), 'Loan created!');
    }

   /**
      * Responds to requests to GET /loan/show/{id}
   */
    public function show($id)
    {
        $loan = Loan::find($id);
        
        if (is_null($loan)) {
            return $this->handleError('Loan not found!');
        }
        if( $loan->user_id ==  Auth::User()->id){
            return $this->handleResponse(new LoanResource($loan), 'Loan retrieved.');
        } else{
            return $this->handleError('Loan not found!');
        }
      
    }
    
    /**
      * Responds to requests to GET /loan/update/{id}
   */
    public function update(Request $request,$id)
    {
        if(Auth::User()->is_admin  ==1){
            $input = $request->all();
            $validator = Validator::make($input, [
                'status' => 'required'
            ]);

            if($validator->fails()){
                return $this->handleError($validator->errors());       
            }
            $loan = Loan::find($id);
            $loan->status = $input['status'];
            $loan->save();
        
            return $this->handleResponse(new LoanResource($loan), 'Loan successfully updated!');
        } else{
            return $this->handleError('You dont have access to this route');       

        }
    }

    /**
      * Responds to requests to GET /loan/pay/{id}
   */
    public function pay(Request $request,$id){
        $input = $request->all();
      
        $validator = Validator::make($input, [
            'amount' => 'required'
        ]);

        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }
        $loan = Loan::find($id);
        $loanPayment = LoanPayment::where('loan_id', $id)->where('status',0)->first();
        if($loanPayment){
            if($input['amount']>= $loanPayment->amount){
                $loanPayment->status = 1;
                $loanPayment->save();
                $UnpaidloanPayment = LoanPayment::where('loan_id',$id)->where('status',0)->count();
                if($UnpaidloanPayment ==0){
                    $loan->status = 'paid';
                    $loan->save();
                }
            } else{
                return $this->handleError('Invalid amount, please add amount greater than or equal to '.$loanPayment->amount);     
            }
           
        }else{
            return $this->handleError('Invalid data, no records found ');     
        }
       
        return $this->handleResponse(new LoanResource($loan), 'Loan successfully updated!');
    }
   
   
}