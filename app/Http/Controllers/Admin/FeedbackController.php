<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::orderBy('id', 'desc')->get();
        return view('admin.feedback.index')->withFeedbacks($feedbacks);
    }
}
