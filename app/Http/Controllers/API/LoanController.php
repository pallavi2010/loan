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
use App\Interfaces\LoanRepositoryInterface;
use App\Interfaces\LoanPaymentRepositoryInterface;

class LoanController extends BaseController
{

    private LoanRepositoryInterface $loanRepository;
    private LoanPaymentRepositoryInterface $loanPaymentRepository;

    public function __construct(LoanRepositoryInterface $loanRepository,LoanPaymentRepositoryInterface $loanPaymentRepository) 
    {
        $this->loanRepository = $loanRepository;
        $this->loanPaymentRepository = $loanPaymentRepository;
    }
    /**
      * Responds to requests to GET /loan/all
   */
    public function index()
    {
        $loans=$this->loanRepository->getAll();
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

        $loan=$this->loanRepository->createLoan($input);
       
        //create weekly loan payments
        if($loan){
            $termPaymentAmount=$this->loanRepository->calculateRepaymentAmount($loan->id);
            if($termPaymentAmount != FALSE){
                $days=7;
                foreach($termPaymentAmount as $key=>$term_payment){
    
                    $daysToAdd=$days*$key;
                    $currentDateTime = Carbon::now();
                    $newDateTime = Carbon::now()->addDays($daysToAdd)->toDateString ();
             
                    $data['amount']=$term_payment;
                    $data['status']=0;
                    $data['payment_date']= $newDateTime;
                    $data['loan_id']=$loan->id; 
                    $loanPayment =$this->loanPaymentRepository->createLoanPayment($data);
                }
            } else{
                return $this->handleError('Loan not found!');
            }
            



        }
        return $this->handleResponse(new LoanResource($loan), 'Loan created!');
    }

   /**
      * Responds to requests to GET /loan/show/{id}
   */
    public function show($id)
    {
        $loan = $this->loanRepository->getLoanById($id);
        
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

            $loan=$this->loanRepository->updateLoan($id,['status'=>$input['status']]);
            if( $loan){
                return $this->handleResponse(new LoanResource($loan), 'Loan successfully updated!');
            } else{
                return $this->handleError('Something went wrong, please try again.');   
            }
           
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
        $loan = $this->loanRepository->getLoanById($id);
        
        if (is_null($loan)) {
            return $this->handleError('Loan not found!');
        }
        $loanPayment = $this->loanPaymentRepository->getfirstPendingRecord($id);
        if($loanPayment){
            if($input['amount']>= $loanPayment->amount){
                $loanPayment = $this->loanPaymentRepository->markPaid($loanPayment->id);
                $UnpaidloanPayment = $this->loanPaymentRepository->getUnpaid($id);
                if($UnpaidloanPayment ==0){
                    $loan=$this->loanRepository->updateLoan($loan->id,['status'=>'paid']);
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