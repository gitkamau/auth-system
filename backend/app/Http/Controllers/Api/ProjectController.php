<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Video;
use App\Models\Files;
use App\Models\Task;
use App\Models\Challenge;
use App\Models\Submission;
use App\Models\Certificates;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProjectController extends ApiController
{
    public function index()
    {
        $projects = Project::all();
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'company_id' => 'required|exists:companies,id',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'certificate_template' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $project = Project::create($validator->validated());
            return response()->json($project, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create project.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $project = Project::findOrFail($id);
            return response()->json($project);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Project not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'company_id' => 'required|exists:companies,id',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'certificate_template' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $project = Project::findOrFail($id);
            $project->update($validator->validated());
            return response()->json($project, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update project.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Project::destroy($id);
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete project.'], 500);
        }
    }

    public function addVideo(Request $request, $projectId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'video_url' => 'required|url',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $video = new Video([
                'title' => $request->title,
                'description' => $request->description,
                'video_url' => $request->video_url,
                'project_id' => $projectId,
            ]);

            $video->save();

            return response()->json($video, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add video to project.'], 500);
        }
    }

    public function addFile(Request $request, $projectId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file' => 'required|file',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $file = $request->file('file');
            $path = $file->store('files', 'public');

            $uploadedFile = new Files([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'project_id' => $projectId,
            ]);

            $uploadedFile->save();

            return response()->json($uploadedFile, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to upload file to project.'], 500);
        }
    }

    public function addTask(Request $request, $projectId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $task = new Task([
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'project_id' => $projectId,
            ]);

            $task->save();

            return response()->json($task, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add task to project.'], 500);
        }
    }

    public function addChallenge(Request $request, $projectId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'instructions' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $challenge = new Challenge([
                'title' => $request->title,
                'description' => $request->description,
                'instructions' => $request->instructions,
                'project_id' => $projectId,
            ]);

            $challenge->save();

            return response()->json($challenge, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add challenge to project.'], 500);
        }
    }

    public function addSubmission(Request $request, $projectId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'task_id' => 'required_without:challenge_id|exists:tasks,id',
                'challenge_id' => 'required_without:task_id|exists:challenges,id',
                'submission_file' => 'required|file',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $file = $request->file('submission_file');
            $path = $file->store('submissions', 'public');

            $submission = new Submission([
                'user_id' => $request->user_id,
                'project_id' => $projectId,
                'task_id' => $request->task_id ?? null,
                'challenge_id' => $request->challenge_id ?? null,
                'submission_file_path' => $path,
            ]);

            $submission->save();

            return response()->json($submission, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to submit file.'], 500);
        }
    }

    public function issueCertificate(Request $request, $projectId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',

            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }


            $certificate = new Certificates([
                'user_id' => $request->user_id,
                'project_id' => $projectId,
                'certificate_url' => 'path_to_generated_certificate.pdf',
            ]);

            $certificate->save();

            return response()->json($certificate, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to issue certificate.'], 500);
        }
    }
}
