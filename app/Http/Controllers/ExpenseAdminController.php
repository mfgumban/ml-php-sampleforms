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

    public function index(Request $request)
    {
        $qtext = $request->input('qtext');
        $qtext = $qtext == null ? '' : $qtext;
        $service = new AppService();
        $search = $service->searchExpenses($qtext);
        return view('expense.admin')->with('search', $search);
    }

    public function receipt($expenseId) {
        $service = new AppService();
        $result = $service->getExpenseReceipt($expenseId);

        return response($result['content'])
            ->header('Content-Type', $result['content-type']);
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
