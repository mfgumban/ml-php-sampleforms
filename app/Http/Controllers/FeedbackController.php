<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppService;
use App\FeedbackModel;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('feedback');
    }

    public function done()
    {
        return view('feedback-done');
    }

    public function submit(Request $request)
    {
        $model = new FeedbackModel();
        $model->fromRequest($request);

        // validate content

        // save to db
        $service = new AppService();
        $success = $service->submitFeedback($model);
        if ($success) {
            return redirect()->action('FeedbackController@done');
        }
        else {
            return redirect()->view('oops');
        }
    }
}
