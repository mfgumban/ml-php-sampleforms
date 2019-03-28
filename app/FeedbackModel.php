<?php

namespace App;

use Illuminate\Http\Request;

class FeedbackModel
{
  private $attributes = [];

  public function fromRequest(Request $request) {
    $this->attributes = [
      'category' => $request->input('category'),
      'feedback' => $request->input('feedback'),
      'email' => $request->input('email'),
      'anonymous' => $request->input('anonymous') == 'on' ? true : false,
    ];
  }

  public function getAttributes() {
    return $this->attributes;
  }
}
