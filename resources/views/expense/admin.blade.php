@extends('layouts.app')

@section('content')
<div class="container">
  <form action="{{ action('ExpenseAdminController@index') }}" method="GET">
    <div class="row">
      <div class="input-group mb-3">
        <input type="text" class="form-control" id="qtext" name="qtext" value="{{ Request::get('qtext') }}">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="button">Search</button>
        </div>
      </div>
    </div>
  </form>
  <div class="row justify-content-center">
    <div class="card-columns">
      @foreach($search['results'] as $result)
      <?php $expense = collect($result['expense']) ?>
      <div class="card">
        <img class="card-img-top" src="{{ action('ExpenseAdminController@receipt', ['expenseId' => $result['expenseId']]) }}" style="object-fit:cover">
        <div class="card-body">
          <h3 class="card-title">
            {{ $expense->get('type') }}
            @if($expense->get('status') == 'Approved')
            <span class="badge badge-success">Approved</span>
            @elseif($expense->get('status') == 'Rejected')
            <span class="badge badge-danger">Rejected</span>
            @endif
          </h3>
          <a target="_blank" href="{{ action('ExpenseAdminController@receipt', ['expenseId' => $result['expenseId']]) }}">Receipt</a>
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
