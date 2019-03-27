@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1 class="display-1">Your Feedback</h1>
      <p>
        We would like your feedback to improve our services.
      </p>
      <hr/>
      <form action="{{ action('FeedbackController@submit') }}" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="category">What kind of feedback do you wish to provide?</label>
          <select class="form-control" id="category" name="category">
            <option>Compliment</option>
            <option>Suggestion</option>
            <option>Complaint</option>
          </select>
        </div>
        <div class="form-group">
          <label for="feedback">Please leave your feedback below:</label>
          <textarea class="form-control" id="feedback" name="feedback" rows="5" placeholder="Enter your feedback"></textarea>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
        </div>
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="anonymous" name="anonymous">
          <label class="form-check-label" for="anonymous">No thanks, I'd rather not</label>
        </div>
        <hr/>
        <div class="form-group">
          <input class="btn btn-primary" type="submit" name="submit" value="Submit Feedback">
        </div>
      </form>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  $("#anonymous").change(function() {
    $("#email").prop('readonly', this.checked);
  });
});
</script>
@endsection
