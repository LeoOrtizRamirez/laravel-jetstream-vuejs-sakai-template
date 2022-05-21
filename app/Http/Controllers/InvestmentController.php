<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\User;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = (int) Loan::sum('amount');
        $investment = (int) Investment::sum('amount');

        $balance = (int) Loan::sum('balance');
        $amount = (int) Loan::sum('amount');
        $gain =  $balance - $amount;

        $investments = Investment::with('user')->get();
        return Inertia::render('Investment/Index', compact('investments', 'investment', 'loans', 'gain'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return Inertia::render('Investment/Create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $investment = new Investment;
        $investment->user_id = $request->user_id;
        $investment->amount = $request->amount;
        $investment->save();
        return Redirect::route('investment.index');
        //$investments = Investment::all();
        //return Inertia::render('Investment/Index', compact('investments'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function show(Investment $investment)
    {
        return Inertia::render('Investment/Show', compact('investment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function edit(Investment $investment)
    {
        $users = User::all();
        return Inertia::render('Investment/Edit', compact('investment','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Investment $investment)
    {

        $investment = Investment::find($investment->id);
        $investment->user_id = $request->user_id;
        $investment->amount = $request->amount;
        $investment->save();
        return Redirect::route('investment.index');
        //return Inertia::render('Investment/Edit', compact('investment','users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Investment $investment)
    {
        $investment->delete();
        return Redirect::route('investment.index');
    }
}
