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
        $user = Auth::user();
        $isOwner = (int)$project->user_id === (int)$user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;
        $isTeam = $project->users()->where('users.id', $user->id)->exists();
        if (!($isOwner || $isAdmin || $isTeam)) {
            abort(403);
        }

        $tasks = $project->tasks()->with('user')->get()->groupBy('status');
        $users = $project->users()->get();
        if ($project->user) {
            $users = $users->push($project->user)->unique('id');
        }
        return view('admin.tasks.index', compact('project', 'tasks', 'users'));
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'nullable|in:to_do,in_progress,completed',
        ]);

        $user = Auth::user();
        $isOwner = (int)$project->user_id === (int)$user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;
        $isTeam = $project->users()->where('users.id', $user->id)->exists();
        if (!($isOwner || $isAdmin || $isTeam)) {
            abort(403);
        }

        $project->tasks()->create([
            'assigned_to' => $request->input('assigned_to'),
            'created_by' => $user->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
            'priority' => $request->input('priority'),
            'status' => $request->input('status', 'to_do'),
        ]);

        return redirect()->route('projects.tasks.index', $project)->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {

        $user = Auth::user();
        $project = $task->project;
        $isOwner = $project && (int)$project->user_id === (int)$user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;
        $isManager = method_exists($user, 'hasRole') ? $user->hasRole('manager') : false;
        $isTeam = $project ? $project->users()->where('users.id', $user->id)->exists() : false;
        $isAssignee = (int)$task->assigned_to === (int)$user->id;
        if (!($isOwner || $isAdmin || $isManager || $isTeam || $isAssignee)) {
            abort(403);
        }

        $canEditTask = $isOwner || $isAdmin || $isManager;
        $users = collect();
        if ($project) {
            $users = $project->users()->get();
            if ($project->user) {
                $users = $users->push($project->user)->unique('id');
            }
        }

        $task->loadMissing('checklistItems');

        return view('admin.tasks.show', compact('task', 'canEditTask', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:to_do,in_progress,completed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $user = Auth::user();
        $project = $task->project;
        $isOwner = $project && (int)$project->user_id === (int)$user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;
        $isManager = method_exists($user, 'hasRole') ? $user->hasRole('manager') : false;
        if (!($isOwner || $isAdmin || $isManager)) {
            abort(403);
        }

        $task->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
            'priority' => $request->input('priority'),
            'status' => $request->input('status'),
            'assigned_to' => $request->input('assigned_to'),
        ]);

        return redirect()->route('projects.tasks.index', $task->project_id)->with('success', 'Task updated successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $user = Auth::user();
        $request->validate([
            'status' => 'required|in:to_do,in_progress,completed',
        ]);
        $project = $task->project;
        $isOwner = $project && (int)$project->user_id === (int)$user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;
        $isTeam = $project ? $project->users()->where('users.id', $user->id)->exists() : false;
        $isAssignee = (int)$task->assigned_to === (int)$user->id;
        if (!($isOwner || $isAdmin || $isTeam || $isAssignee)) {
            abort(403);
        }

        $task->status = $request->input('status');
        $task->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'status' => $task->status,
            ]);
        }

        return back()->with('success', 'Task status updated successfully.');
    }

    public function assignToMe(Task $task)
    {
        $user = Auth::user();
        $project = $task->project;
        $isOwner = $project && (int)$project->user_id === (int)$user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;
        $isTeam = $project ? $project->users()->where('users.id', $user->id)->exists() : false;
        if (!($isOwner || $isAdmin || $isTeam)) {
            abort(403);
        }
        if (!$task->assigned_to) {
            $task->assigned_to = $user->id;
            $task->save();
        }
        return back()->with('success', 'Task assigned to you.');
    }

    public function destroy(Task $task)
    {
        $user = Auth::user();
        $project = $task->project;
        $isOwner = $project && (int)$project->user_id === (int)$user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;
        $isManager = method_exists($user, 'hasRole') ? $user->hasRole('manager') : false;
        if (!($isOwner || $isAdmin || $isManager)) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('projects.tasks.index', $task->project_id)->with('success', 'Task deleted.');
    }

    public function addChecklistItem(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $project = $task->project;
        $isOwner = $project && (int)$project->user_id === (int)$user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;
        $isManager = method_exists($user, 'hasRole') ? $user->hasRole('manager') : false;
        $isTeam = $project ? $project->users()->where('users.id', $user->id)->exists() : false;
        if (!($isOwner || $isAdmin || $isManager || $isTeam)) {
            abort(403);
        }

        $task->checklistItems()->create([
            'title' => $request->input('title'),
            'is_completed' => 0,
        ]);

        return back()->with('success', 'Checklist item added.');
    }

    public function toggleChecklistItem(TaskCheckListItem $item)
    {
        $task = $item->task;
        $user = Auth::user();
        $project = $task?->project;
        $isOwner = $project && (int)$project->user_id === (int)$user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;
        $isManager = method_exists($user, 'hasRole') ? $user->hasRole('manager') : false;
        $isTeam = $project ? $project->users()->where('users.id', $user->id)->exists() : false;
        $isAssignee = (int)$task?->assigned_to === (int)$user->id;
        if (!($isOwner || $isAdmin || $isManager || $isTeam || $isAssignee)) {
            abort(403);
        }

        $item->is_completed = $item->is_completed ? 0 : 1;
        $item->save();

        return back()->with('success', 'Checklist updated.');
    }

    public function deleteChecklistItem(TaskCheckListItem $item)
    {
        $task = $item->task;
        $user = Auth::user();
        $project = $task?->project;
        $isOwner = $project && (int)$project->user_id === (int)$user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;
        $isManager = method_exists($user, 'hasRole') ? $user->hasRole('manager') : false;
        if (!($isOwner || $isAdmin || $isManager)) {
            abort(403);
        }

        $item->delete();

        return back()->with('success', 'Checklist item removed.');
    }
}
