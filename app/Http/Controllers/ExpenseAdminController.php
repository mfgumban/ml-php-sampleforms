<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppService;

class ExpenseAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        $service = new AppService();
        $search = $service->searchExpenses(''); // get all
        return view('expense.admin')->with('search', $search);
    }

    public function approve(Request $request) {
        $expenseId = $request->query('expenseId');
        $service = new AppService();
        $success = $service->approveExpense($expenseId);
        if ($success) {
            return redirect()->action('ExpenseAdminController@index');
        }
        else {
            return redirect()->view('oops');
        } 
    }

    public function reject(Request $request) {
        $expenseId = $request->query('expenseId');
        $service = new AppService();
        $success = $service->rejectExpense($expenseId);
        if ($success) {
            return redirect()->action('ExpenseAdminController@index');
        }
        else {
            return redirect()->view('oops');
        } 
    }
}
