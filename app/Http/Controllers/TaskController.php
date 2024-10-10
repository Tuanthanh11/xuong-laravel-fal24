<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Lấy tất cả các nhiệm vụ của một dự án
    public function index($projectId)
    {
        $tasks = Task::where('project_id', $projectId)->get();
        return response()->json($tasks);
    }

    // Lấy thông tin của một nhiệm vụ cụ thể
    public function show($projectId, $id)
    {
        $task = Task::where('project_id', $projectId)->find($id);
        if (!$task) {
            return response()->json(['message' => 'Nhiệm vụ không tồn tại'], 404);
        }
        return response()->json($task);
    }

    // Tạo một nhiệm vụ mới trong một dự án cụ thể
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:not_started,in_progress,completed',
        ]);

        $project = Project::find($projectId);
        if (!$project) {
            return response()->json(['message' => 'Dự án không tồn tại'], 404);
        }

        $task = $project->tasks()->create($request->all());

        return response()->json($task, 201);
    }

    // Cập nhật thông tin của một nhiệm vụ
    public function update(Request $request, $projectId, $id)
    {
        $task = Task::where('project_id', $projectId)->find($id);
        if (!$task) {
            return response()->json(['message' => 'Nhiệm vụ không tồn tại'], 404);
        }

        $task->update($request->all());

        return response()->json($task);
    }

    // Xóa một nhiệm vụ
    public function destroy($projectId, $id)
    {
        $task = Task::where('project_id', $projectId)->find($id);
        if (!$task) {
            return response()->json(['message' => 'Nhiệm vụ không tồn tại'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Nhiệm vụ đã bị xóa']);
    }
}
