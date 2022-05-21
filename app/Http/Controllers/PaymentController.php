<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Loan;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function setToPay($id, $view){
        $payment = Payment::find($id);
        $payment->status_id=2;
        $payment->save();
        $loan = Loan::find($payment->loan_id);
        $all_payments = Payment::where('loan_id', $payment->loan_id)->get();
        $validator = true;
        foreach ($all_payments as $key => $value) {
            if($value->status_id != 2){
                $validator = false;
            }
        }
        if($validator){
            $loan->status_id = 2;
            $loan->save();
        }

        $payments = Payment::with('status')->where('loan_id',$payment->loan_id)->get();

        if($view=="show"){
            return Redirect::route('loan.show',$payment->loan_id);
        }
        return Redirect::route('payment.index');
    }

    public function index()
    {   
        $payments = Payment::select('payments.*','customers.name','statuses.name as status_name','statuses.id as status_id')
        ->join('loans','loans.id','payments.loan_id')
        ->join('customers','customers.id','loans.customer_id')
        ->join('statuses','statuses.id','payments.status_id')
        ->orderBy('payment_date','ASC')
        ->get();
        foreach ($payments as $key => $value) {
            $dates[] = $value->payment_date;
        }
        $dates = array_unique($dates);
        return Inertia::render('Payment/Index', compact('payments','dates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Customer/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->document = $request->document;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->save();

        $customers = Customer::all();
        return Inertia::render('Customer/Index', compact('customers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return Inertia::render('Customer/Show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return Inertia::render('Customer/Edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //$customers = Customer::all();
        $customer = Customer::find($customer->id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->document = $request->document;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->save();


        return Redirect::route('customer.index');
        //return Inertia::render('Customer/Index', compact('customers'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return Redirect::route('customer.index');
    }
}
