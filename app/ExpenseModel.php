<?php

namespace App;

use Illuminate\Http\Request;

class ExpenseModel
{
  private $attributes = [];

  public function fromRequest(Request $request) {
    $this->attributes = [
      'expenseType' => $request->input('expenseType'),
      'reimbursable' => $request->input('reimbursable'),
      'name' => $request->input('name'),
      'reason' => $request->input('reason'),
    ];
  }

  public function getAttributes() {
    return $this->attributes;
  }
}
