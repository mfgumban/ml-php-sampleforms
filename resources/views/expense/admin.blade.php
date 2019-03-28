@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="card-deck">
      @foreach($search['results'] as $result)
      <?php $expense = collect($result['expense']) ?>
      <div class="card">
        <div class="card-body">
          <h3 class="card-title">{{ $expense->get('type') }}</h3>
          <ul>
          @foreach($expense->except(['type']) as $key => $value)
            <li>{{ $key }}: {{ $value }}</li>
          @endforeach
          </ul>
          @if($expense->get('status') == 'Open')
          <div class="row">
            <div class="col-sm-4">
              <form action="{{ action('ExpenseAdminController@approve', ['expenseId' => $result['expenseId']]) }}" method="POST">
                {{ csrf_field() }}
                <input class="btn btn-primary" type="submit" name="approve" value="Approve">
              </form>
            </div>
            <div class="col-sm-4">
              <form action="{{ action('ExpenseAdminController@reject', ['expenseId' => $result['expenseId']]) }}" method="POST">
                {{ csrf_field() }}
                <input class="btn btn-danger" type="submit" name="reject" value="Reject">
              </form>
            </div>
          </div>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
