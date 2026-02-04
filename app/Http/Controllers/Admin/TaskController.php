<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projects as Project;
use App\Models\TaskCheckListItem;
use App\Models\Tasks as Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    public function index(Project $project)
    {
        try {

            $user = Auth::user();
            $tasks = $project->tasks()->with('user')->get()->groupBy('status');
            $users = $project->users()->get();
            if ($project->user) {
                $users = $users->push($project->user)->unique('id');
            }
            return view('admin.tasks.index', compact('project', 'tasks', 'users'));
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function store(Request $request, Project $project)
    {
        try {
            $request->validate([
                'assigned_to' => 'required|exists:users,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'nullable|date',
                'priority' => 'required|in:low,medium,high',
                'status' => 'nullable|in:to_do,in_progress,completed',
            ]);

            $user = Auth::user();

            $project->tasks()->create([
                'assigned_to' => $request->input('assigned_to'),
                'created_by' => $user->id,
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'due_date' => $request->input('due_date'),
                'priority' => $request->input('priority'),
                'status' => $request->input('status', 'to_do'),
                'company_id' => session('company_id'),
            ]);

            return redirect()->route('projects.tasks.index', $project)->with('success', 'Task created successfully.');
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function show(Task $task)
    {

        try {
            $user = Auth::user();
            $project = $task->project;

            $users = collect();
            if ($project) {
                $users = $project->users()->get();
                if ($project->user) {
                    $users = $users->push($project->user)->unique('id');
                }
            }

            $task->loadMissing('checklistItems');

            return view('admin.tasks.show', compact('task',  'users'));
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function update(Request $request, Task $task)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'nullable|date',
                'priority' => 'required|in:low,medium,high',
                'status' => 'required|in:to_do,in_progress,completed',
                'assigned_to' => 'nullable|exists:users,id',
            ]);

            // dd('here');
            $user = Auth::user();
            $project = $task->project;


            $task->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'due_date' => $request->input('due_date'),
                'priority' => $request->input('priority'),
                'status' => $request->input('status'),
                'assigned_to' => $request->input('assigned_to'),
                'company_id' => session('company_id'),

            ]);

            return redirect()->route('projects.tasks.index', $task->project_id)->with('success', 'Task updated successfully.');
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function updateStatus(Request $request, Task $task)
    {
        try {
            $user = Auth::user();
            $request->validate([
                'status' => 'required|in:to_do,in_progress,completed',
            ]);
            $project = $task->project;

            $task->status = $request->input('status');
            $task->save();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'status' => $task->status,
                ]);
            }

            return back()->with('success', 'Task status updated successfully.');
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function assignToMe(Task $task)
    {
        try {
            $user = Auth::user();
            $project = $task->project;

            if (!$task->assigned_to) {
                $task->assigned_to = $user->id;
                $task->save();
            }
            return back()->with('success', 'Task assigned to you.');
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function destroy(Task $task)
    {
        try {
            $user = Auth::user();
            $project = $task->project;


            $task->delete();

            return redirect()->route('projects.tasks.index', $task->project_id)->with('success', 'Task deleted.');
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function addChecklistItem(Request $request, Task $task)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
            ]);
            $task->checklistItems()->create([
                'title' => $request->input('title'),
                'is_completed' => 0,
                'company_id' => session('company_id'),
            ]);

            return back()->with('success', 'Checklist item added.');
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function toggleChecklistItem(TaskCheckListItem $item)
    {
        try {
            $task = $item->task;
            $user = Auth::user();
            $project = $task?->project;

            $item->is_completed = $item->is_completed ? 0 : 1;
            $item->save();

            return back()->with('success', 'Checklist updated.');
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function deleteChecklistItem(TaskCheckListItem $item)
    {
        try {
            $task = $item->task;
            $user = Auth::user();
            $project = $task?->project;

            $item->delete();

            return back()->with('success', 'Checklist item removed.');
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }
}
