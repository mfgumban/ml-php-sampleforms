@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1 class="display-1">Enter Details</h1>
      <p>
        Enter details for your expense report.
      </p>
      <hr/>
      <form action="{{ action('ExpenseController@postStep1') }}" method="POST">
        {{ csrf_field() }}

        <!-- show validation errors -->
        @if($errors->any())
        <div class="alert alert-danger">
          <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
          </ul>
        </div>
        @endif
        <div class="form-group">
          <label for="category">Expense Type</label>
          <select class="form-control" id="expenseType" name="expenseType">
          @foreach($expenseTypes as $expenseType)
            <option>{{ $expenseType }}</option>
          @endforeach
          </select>
        </div>
        <fieldset class="form-group">
          <div class="row">
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="reimbursable" id="reimbursable1" value="yes" checked>
                <label class="form-check-label" for="reimbursable1">Reimbursable</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="reimbursable" id="reimbursable2" value="no">
                <label class="form-check-label" for="reimbursable2">Non-reimbursable</label>
              </div>
            </div>
          </div>
        </fieldset>
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
        </div>
        <div class="form-group">
          <label for="feedback">Reason</label>
          <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Enter reason for the expense"></textarea>
        </div>
        <hr/>
        <div class="form-group">
          <input class="btn btn-primary" type="submit" name="next" value="Next">
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
