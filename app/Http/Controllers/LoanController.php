<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Customer;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::with('status','user','customer')->get();
        return Inertia::render('Loan/Index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $users = User::all();
        return Inertia::render('Loan/Create', compact('customers', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loan = new Loan;
        $loan->user_id = $request->user_id;
        $loan->customer_id = $request->customer_id;
        $loan->amount = $request->amount;
        $loan->interest = $request->interest;
        $loan->balance = $request->balance;
        $loan->total_fee = $request->total_fee;
        $loan->way_to_pay = $request->way_to_pay;
        $loan->payment_date = $request->payment_date;
        $loan->save();

        //dd($loan);

        if(isset($request->total_fee)){
            for ($i=0; $i < $request->total_fee; $i++) { 
                $model = new Payment;
                $model->loan_id = $loan->id;
                $model->fee = $i+1;

                $day = date("d",strtotime($request->payment_date));
                if($i==0){
                    $date = date("Y-m-d",strtotime($request->payment_date));
                }else if($request->way_to_pay=="30"){
                    $date = date("Y-m-d",strtotime($request->payment_date."+ 1 month"));
                }else if($day=="15"){
                    $date = date("Y-m-d",strtotime($request->payment_date."+ ".$request->way_to_pay." days"));
                }else{
                    $date = date("Y-m-d",strtotime($request->payment_date."+ ".$request->way_to_pay." days"));
                }
                $model->payment_date = $date;
                $model->amount = $request->balance / $request->total_fee;
                $model->save();

                $request->payment_date = $date;
            }
        }


        $loans = Loan::all();
        return Redirect::route('loan.index');
        //return Inertia::render('Loan/Index', compact('loans'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        $payments = Payment::with('status')->where('loan_id',$loan->id)->get();
        $total = 0;
        foreach ($payments as $key => $value) {
            $total +=  (int) $value->amount;
        }
        return Inertia::render('Loan/Show', compact('loan', 'payments', 'total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        return Inertia::render('Loan/Edit', compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        $loan->update($request);
        $loans = Loan::all();
        return Inertia::render('Loan/Index', compact('loans'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        $payments = Payment::where('loan_id', $loan->id)->get();
        if(isset($payments) && !is_null($payments)){
            foreach ($payments as $key => $value) {
                $value->delete();
            }
        }
        $loan->delete();
        return Redirect::route('loan.index');
    }

    

    public function getLoan($loan_id)
    {
        $loan = Loan::find($loan_id);
        $payments = Payment::with('status')->where('loan_id',$loan_id)->get();
        $total = 0;
        foreach ($payments as $key => $value) {
            $total +=  (int) $value->amount;
        }
        return Inertia::render('Loan/Show', compact('loan', 'payments', 'total'));
    }
}
