@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1 class="display-1">Receipt</h1>
      <p>
        Upload your receipt.
      </p>
      <hr/>
      <form action="{{ action('ExpenseController@postStep2') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
          <input type="hidden" id="expenseId" name="expenseId" value="{{ $expenseId }}">
          <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload">
          <small class="form-text text-muted">Please upload a valid image.</small>
          <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
