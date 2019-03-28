<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppService;
use App\ExpenseModel;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getStep1()
    {
        $service = new AppService();
        $expenseTypes = $service->getExpenseTypes();
        return view('expense.step1')->with('expenseTypes', $expenseTypes);
    }

    public function getStep2()
    {
        return view('expense.step2');
    }

    public function postStep1(Request $request)
    {
        $validatedData = $request->validate([
            'expenseType' => 'required',
            'reimbursable' => 'required',
            'name' => 'required',
            'reason' => 'required',
        ]);

        $model = new ExpenseModel();
        $model->fromRequest($request);

        // save to db
        $service = new AppService();
        $success = $service->addExpense($model);
        if ($success) {
            return redirect()->action('ExpenseController@getStep2');
        }
        else {
            return redirect()->view('oops');
        }
    }

    public function postStep2(Request $request)
    {
        
    }
}
