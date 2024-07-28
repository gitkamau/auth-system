<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Models\Submission;

class SubmissionController extends ApiController
{
    public function store(Request $request)
    {
        $submission = new Submission;
        $submission->task_id = $request->task_id;
        $submission->user_id = $request->user_id;
        $submission->content = $request->content;
        $submission->save();

        return response()->json($submission, 201);
    }
}
